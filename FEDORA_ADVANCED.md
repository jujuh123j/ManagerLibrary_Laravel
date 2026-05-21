# 🔴 Fedora: Guia Avançado de Troubleshooting

Guia completo para resolver problemas específicos do Fedora ao usar Docker e Docker Compose.

---

## 📋 Índice

1. [Entendendo SELinux](#entendendo-selinux)
2. [Problemas com SELinux](#problemas-com-selinux)
3. [Problemas com Firewall](#problemas-com-firewall)
4. [Problemas com Permissões](#problemas-com-permissões)
5. [Problemas com Sistema de Arquivos](#problemas-com-sistema-de-arquivos)
6. [Problemas com DNS/Rede](#problemas-com-dnsrede)
7. [Checklist de Diagnóstico](#checklist-de-diagnóstico)

---

## 🔐 Entendendo SELinux

### O que é SELinux?

**SELinux (Security-Enhanced Linux)** é um sistema de controle de acesso obrigatório no kernel do Linux. O Fedora utiliza SELinux por padrão, o que é mais seguro, mas também mais complexo que outras distribuições.

### Diferenças: Fedora vs Ubuntu

| Aspecto | Fedora | Ubuntu |
|--------|--------|--------|
| **MAC (Mandatory Access Control)** | SELinux (ativo) | AppArmor (opcional) |
| **Restritivo por padrão** | ✅ Sim, mais restritivo | ❌ Não, mais permissivo |
| **Sufixo em volumes Docker** | `:Z` ou `:z` | Não necessário |
| **Contexto de arquivo** | Obrigatório | Não aplicável |
| **Gerenciador de pacotes** | DNF | APT |

### Verificar Status do SELinux

```bash
# Verificar se SELinux está ativo
getenforce

# Ver modo:
# - Enforcing: Ativo e restritivo (padrão)
# - Permissive: Ativo mas só loga (debug)
# - Disabled: Desativado

# Ver informações detalhadas
sestatus

# Ver logs de SELinux
sudo tail -50 /var/log/audit/audit.log

# Ver logs em tempo real
sudo tail -f /var/log/audit/audit.log
```

---

## ⚠️ Problemas com SELinux

### Problema 1: "Permission denied" em Volumes

**Erro típico**:
```
stat() "/var/www/public/" failed (13: Permission denied)
```

**Causa**: SELinux está negando acesso ao volume montado.

**Solução A: Adicionar Sufixo `:Z` (Recomendado)**

Edite `docker-compose.yml`:

```yaml
services:
  app:
    volumes:
      - .:/var/www:Z                    # ← Adicione :Z
      
  web:
    volumes:
      - .:/var/www:Z                    # ← Adicione :Z
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf:Z
```

O sufixo `:Z` permite que SELinux compartilhe o contexto entre containers.

**Solução B: Configurar Contexto SELinux**

```bash
# Adicionar contexto para o diretório do projeto
sudo semanage fcontext -a -t container_file_t "$(pwd)(/.*)?"

# Aplicar contexto
sudo restorecon -R .

# Verificar
ls -Z
```

**Solução C: Modo Permissive (Menos Seguro)**

```bash
# Ativar modo permissive (SELinux continua monitorando mas não bloqueia)
sudo semanage permissive -a container_t

# Desativar modo permissive
sudo semanage permissive -d container_t

# ⚠️ Nota: Isso reduz a segurança! Use apenas para debug.
```

### Problema 2: Container não consegue escrever em volumes

**Erro típico**:
```
[Errno 13] Permission denied: '/var/www/storage/logs/laravel.log'
```

**Causa**: Contexto SELinux incorreto.

**Solução**:

```bash
# Opção 1: Usar :Z nos volumes
docker-compose down
# Edite docker-compose.yml e adicione :Z
docker-compose up -d

# Opção 2: Configurar manualmente
sudo semanage fcontext -a -t container_file_t "$(pwd)/storage(/.*)?"
sudo semanage fcontext -a -t container_file_t "$(pwd)/bootstrap(/.*)?"
sudo restorecon -R ./storage ./bootstrap

# Opção 3: Criar contexto genérico
sudo semanage fcontext -a -t container_file_t "$(pwd)(/.*)?"
sudo restorecon -R .
```

### Problema 3: Ver Logs de Negação do SELinux

```bash
# Ver últimas negações
sudo tail -20 /var/log/audit/audit.log

# Ver especificamente docker/container
sudo grep -i container /var/log/audit/audit.log | tail -20

# Filtrar por tipo
sudo ausearch -m avc | tail -20
```

### Problema 4: Desabilitar SELinux Temporariamente (Debug)

```bash
# ⚠️ APENAS PARA DEBUG! Não faça em produção!

# Setar para modo permissive (não bloqueia, apenas loga)
sudo semanage -t permissive_type_t container_t

# Ver modo atual
getenforce

# Voltar ao normal
sudo semanage -t type_t container_t
```

---

## 🔥 Problemas com Firewall

### Verificar Status do Firewall

```bash
# Ver se firewall está ativo
sudo firewall-cmd --state

# Ver configuração completa
sudo firewall-cmd --list-all

# Ver portas abertas
sudo firewall-cmd --list-ports
```

### Problema 1: Porta 8000 Bloqueada

**Erro típico**: Conexão recusada ao acessar `http://localhost:8000`

**Solução**:

```bash
# Abrir porta 8000 temporariamente
sudo firewall-cmd --add-port=8000/tcp

# Abrir permanentemente
sudo firewall-cmd --permanent --add-port=8000/tcp

# Recarregar firewall
sudo firewall-cmd --reload

# Verificar se abriu
sudo firewall-cmd --list-ports
```

### Problema 2: Outras Portas (MySQL 3306, etc.)

```bash
# Abrir MySQL (3306)
sudo firewall-cmd --permanent --add-port=3306/tcp

# Abrir múltiplas portas
sudo firewall-cmd --permanent --add-port=8000/tcp --add-port=3306/tcp

# Recarregar
sudo firewall-cmd --reload
```

### Problema 3: Conectividade Entre Containers

```bash
# Verificar se containers conseguem se comunicar
docker-compose exec app ping db

# Se não conectar, pode ser firewall
# Abra portas internas (não necessário em rede docker)
docker network inspect <nome_rede>
```

### Problema 4: Ver Regras do Firewall

```bash
# Ver regras ativas
sudo iptables -L -n

# Ver regras do firewall-cmd
sudo firewall-cmd --list-all

# Ver portas e serviços
sudo firewall-cmd --list-services
```

---

## 🔑 Problemas com Permissões

### Problema 1: Grupo Docker sem Permissão

**Erro**: `permission denied while trying to connect to the Docker daemon`

**Solução**:

```bash
# Criar grupo docker (se não existir)
sudo groupadd docker

# Adicionar usuário ao grupo
sudo usermod -aG docker $USER

# IMPORTANTE: Ativar grupo sem logout
newgrp docker

# Verificar (sem sudo!)
docker run hello-world

# Se ainda não funcionar
# Faça logout completo e login novamente
```

### Problema 2: Arquivo .sock Inacessível

**Erro**: `Got permission denied while trying to connect to Docker daemon socket`

**Solução**:

```bash
# Verificar permissões do socket
ls -l /var/run/docker.sock

# Mudar propriedade (se necessário)
sudo chown root:docker /var/run/docker.sock

# Adicionar permissões
sudo chmod 666 /var/run/docker.sock

# Adicionar usuário ao grupo
sudo usermod -aG docker $USER
newgrp docker
```

### Problema 3: Permissões de Arquivo no Projeto

**Erro**: Arquivos com permissões incorretas no diretório do projeto

**Solução**:

```bash
# Mudar propriedade para seu usuário
sudo chown -R $(id -u):$(id -g) ~/ManagerLibrary_Laravel

# Definir permissões corretas
chmod -R 755 ~/ManagerLibrary_Laravel

# Se tiver contexto SELinux
sudo semanage fcontext -a -t container_file_t "$(pwd)(/.*)?"
sudo restorecon -R .
```

### Problema 4: Permissões Dentro do Container

```bash
# Dentro do container, docker entrypoint deve fazer isso automaticamente
# Se não funcionar, execute manualmente:

docker-compose exec app chmod -R 755 /var/www/public
docker-compose exec app chmod -R 775 /var/www/storage
docker-compose exec app chmod -R 775 /var/www/bootstrap/cache
docker-compose exec app chown -R www-data:www-data /var/www/storage
docker-compose exec app chown -R www-data:www-data /var/www/bootstrap/cache
```

---

## 📂 Problemas com Sistema de Arquivos

### Problema 1: Inode Limite Atingido

**Erro**: `No space left on device` mas disco tem espaço

**Verificar**:

```bash
# Ver espaço de disco
df -h

# Ver limite de inodes
df -i

# Ver uso de inodes
stat /

# Ver diretórios com muitos arquivos
for dir in ./*/; do echo "$(find "$dir" -type f | wc -l) files in $dir"; done
```

**Solução**:

```bash
# Limpar volumes Docker não utilizados
docker volume prune

# Limpar imagens não utilizadas
docker image prune

# Limpar cache do npm/composer
docker-compose exec app composer clear-cache
docker-compose exec app npm cache clean --force

# Remover logs grandes
docker-compose exec app rm -rf storage/logs/*
```

### Problema 2: Disco Cheio

```bash
# Ver espaço em disco
df -h

# Encontrar maiores diretórios
du -sh * | sort -hr | head -10

# Limpar Docker completamente
docker system prune -a --volumes
docker image prune --all
docker container prune
```

### Problema 3: Cache do Yum/DNF

```bash
# Limpar cache do DNF
sudo dnf clean all
sudo dnf makecache

# Isso libera GB de espaço em disco
```

---

## 🌐 Problemas com DNS/Rede

### Problema 1: Containers não conseguem resolver nomes

**Erro**: `ERROR: Service "db" failed to build: error during connect`

**Verificar**:

```bash
# Ver configuração de rede
docker-compose config

# Listar redes
docker network ls

# Inspecionar rede
docker network inspect managerlibrary_laravel_library_net

# Testar conectividade
docker-compose exec app nslookup db
docker-compose exec app ping db
```

**Solução**:

```bash
# Resetar redes
docker network prune

# Recrear containers com nova rede
docker-compose down
docker-compose up -d
```

### Problema 2: DNS do Host não Funciona

**Erro**: Containers não conseguem acessar internet

```bash
# Ver configuração DNS do container
docker-compose exec app cat /etc/resolv.conf

# Testar DNS
docker-compose exec app nslookup google.com
docker-compose exec app curl google.com

# Se não funcionar, adicione DNS ao docker-compose.yml:
services:
  app:
    dns:
      - 8.8.8.8
      - 8.8.4.4
```

### Problema 3: Rede do Fedora com Podman

O Fedora pode estar usando **Podman** em vez de Docker.

```bash
# Verificar qual está sendo usado
which docker
which podman

# Se for podman, instale podman-docker para compatibilidade
sudo dnf install -y podman-docker

# Teste
docker --version
```

---

## ✅ Checklist de Diagnóstico

Execute este checklist quando tiver problemas:

### 1. Verificar Instalação do Docker

```bash
# ✅ Docker instalado?
docker --version

# ✅ Docker Compose instalado?
docker-compose --version

# ✅ Docker rodando?
sudo systemctl status docker

# ✅ Grupo docker configurado?
groups $USER | grep docker
```

### 2. Verificar SELinux

```bash
# ✅ SELinux ativo?
getenforce

# ✅ Contextos configurados?
ls -Z ~/ManagerLibrary_Laravel | head -5

# ✅ Logs de erro?
sudo tail -20 /var/log/audit/audit.log
```

### 3. Verificar Firewall

```bash
# ✅ Firewall ativo?
sudo firewall-cmd --state

# ✅ Portas abertas?
sudo firewall-cmd --list-ports

# ✅ Portas necessárias (8000, 3306)?
sudo firewall-cmd --list-ports | grep -E "8000|3306"
```

### 4. Verificar Containers

```bash
# ✅ Containers rodando?
docker-compose ps

# ✅ Nenhum erro?
docker-compose logs | grep -i error

# ✅ Portas corretas?
docker-compose ps | grep -E "0.0.0.0:8000|0.0.0.0:3306"
```

### 5. Verificar Conectividade

```bash
# ✅ Web acessível?
curl -I http://localhost:8000

# ✅ MySQL acessível?
docker-compose exec app mysql -h db -uroot -proot -e "SELECT 1;"

# ✅ Containers se falam?
docker-compose exec app ping db
```

### 6. Verificar Permissões

```bash
# ✅ Propriedade correta?
ls -l ~/ManagerLibrary_Laravel | head -5

# ✅ Dentro do container?
docker-compose exec app ls -l /var/www/public | head -5

# ✅ Arquivo .sock acessível?
ls -l /var/run/docker.sock
```

---

## 🆘 Último Recurso: Reset Completo

Se nada funcionar, recrie tudo do zero:

```bash
# 1. Parar tudo
docker-compose down -v

# 2. Limpar volumes
docker volume prune -f

# 3. Remover imagens
docker rmi $(docker images -q) -f

# 4. Limpar redes
docker network prune -f

# 5. Limpar contexto SELinux (opcional)
sudo semanage fcontext -l | grep -c "$(pwd)"
# Se houver contextos, remova-os:
# sudo semanage fcontext -d -t container_file_t "$(pwd)(/.*)?"

# 6. Reconstruir
docker-compose build --no-cache

# 7. Iniciar
docker-compose up -d

# 8. Diagnosticar
docker-compose ps
docker-compose logs
```

---

## 📞 Suporte Avançado

### Coletar Informações para Suporte

Se precisar pedir ajuda, colete essas informações:

```bash
# Criar relatório de diagnóstico
{
  echo "=== Fedora Version ==="
  cat /etc/fedora-release
  
  echo -e "\n=== Docker Version ==="
  docker --version
  docker-compose --version
  
  echo -e "\n=== SELinux Status ==="
  getenforce
  
  echo -e "\n=== Firewall Status ==="
  sudo firewall-cmd --state
  sudo firewall-cmd --list-ports
  
  echo -e "\n=== Docker Status ==="
  docker ps -a
  
  echo -e "\n=== Container Logs ==="
  docker-compose logs
  
  echo -e "\n=== System Logs (SELinux) ==="
  sudo tail -20 /var/log/audit/audit.log
  
  echo -e "\n=== Disk Space ==="
  df -h
  
  echo -e "\n=== Memory ==="
  free -h
} > diagnostics.txt

# Enviar para suporte (remover informações sensíveis!)
cat diagnostics.txt
```

---

## 📚 Referências

- [Fedora Project](https://getfedora.org/)
- [SELinux Documentation](https://selinuxproject.org/page/Documentation)
- [Fedora Docker Guide](https://docs.fedoraproject.org/en-US/fedora-coreos/docker/)
- [Firewall-cmd Manual](https://firewalld.org/documentation/man-pages/firewall-cmd.html)
- [DNF Package Manager](https://dnf.readthedocs.io/)

---

**Última atualização**: Maio de 2026  
**Versão**: 1.0  
**Mantido por**: ManagerLibrary Team
