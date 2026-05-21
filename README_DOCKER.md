# 📘 ManagerLibrary - Documentação Docker

Bem-vindo! Esta documentação completa ensina como executar a aplicação **ManagerLibrary** usando Docker em diferentes sistemas operacionais.

---

## 📚 Documentos Disponíveis

### 1. **DOCKER_SETUP.md** - Guia Principal ⭐ **COMECE AQUI**
O guia mais completo com instruções passo a passo para:
- ✅ Windows (PowerShell, WSL2)
- ✅ Linux (Ubuntu/Debian)
- ✅ **Fedora (com características especiais de SELinux e Firewall)**
- ✅ Execução, parada e monitoramento de containers
- ✅ Troubleshooting geral

**Leia este documento primeiro!**

```bash
# Abrir o arquivo
cat DOCKER_SETUP.md
```

---

### 2. **DOCKER_COMMANDS.md** - Referência Rápida
Guia rápido com comandos mais utilizados:
- 🚀 Iniciar/parar aplicação
- 📊 Monitoramento e logs
- 🔧 Acessar containers
- 🗄️ Gerenciar banco de dados
- �� Backup e restore
- 🧹 Limpeza de recursos

**Use quando precisar de um comando específico rapidamente.**

```bash
# Abrir o arquivo
cat DOCKER_COMMANDS.md
```

---

### 3. **FEDORA_ADVANCED.md** - Guia Avançado para Fedora
Guia específico para resolver problemas complexos no Fedora:
- 🔐 Entendimento de SELinux
- ⚠️ Problemas e soluções específicas
- 🔥 Configuração de Firewall
- 🔑 Problemas de permissões
- 📂 Problemas de sistema de arquivos
- ✅ Checklist de diagnóstico completo

**Use quando tiver problemas específicos do Fedora ou SELinux.**

```bash
# Abrir o arquivo
cat FEDORA_ADVANCED.md
```

---

## 🚀 Quick Start (30 segundos)

### Windows (PowerShell)

```powershell
# 1. Instalar Docker Desktop
# Baixe em: https://www.docker.com/products/docker-desktop

# 2. Clonar repositório
git clone <url> ManagerLibrary_Laravel
cd ManagerLibrary_Laravel

# 3. Iniciar
docker-compose up -d

# 4. Acessar em: http://localhost:8000
```

### Linux / Fedora (Bash)

```bash
# 1. Instalar Docker
sudo dnf install -y docker docker-compose

# 2. Iniciar Docker
sudo systemctl enable docker
sudo systemctl start docker

# 3. Configurar permissões
sudo groupadd docker
sudo usermod -aG docker $USER
newgrp docker

# 4. Clonar repositório
git clone <url> ManagerLibrary_Laravel
cd ManagerLibrary_Laravel

# 5. Iniciar
docker-compose up -d

# 6. Acessar em: http://localhost:8000
```

---

## 🔑 Dados de Acesso

### Aplicação Web
```
URL: http://localhost:8000
Porta: 8000
```

### Banco de Dados MySQL
```
Host: localhost
Porta: 3306
Usuário: root
Senha: root
Database: biblioteca
```

---

## ❓ Qual Documento Ler?

```
┌─ Primeira vez usando Docker?
│  └─ Leia: DOCKER_SETUP.md (seção correspondente ao seu SO)
│
├─ Precisa de um comando específico?
│  └─ Procure em: DOCKER_COMMANDS.md
│
├─ Usando Fedora e tem problemas?
│  ├─ Erro com SELinux?
│  │  └─ Leia: FEDORA_ADVANCED.md - Problemas com SELinux
│  ├─ Porta bloqueada?
│  │  └─ Leia: FEDORA_ADVANCED.md - Problemas com Firewall
│  └─ Permissões negadas?
│     └─ Leia: FEDORA_ADVANCED.md - Problemas com Permissões
│
├─ Container não inicia?
│  └─ Leia: DOCKER_COMMANDS.md - Troubleshooting Rápido
│
└─ Problema não listado?
   └─ Checklist: FEDORA_ADVANCED.md - Checklist de Diagnóstico
```

---

## 🎯 Tarefas Comuns

### Iniciar aplicação
```bash
docker-compose up -d
```
**Veja**: DOCKER_COMMANDS.md - Comandos Essenciais

### Ver logs
```bash
docker-compose logs -f library_web
```
**Veja**: DOCKER_COMMANDS.md - Visualizar Logs

### Acessar banco de dados
```bash
docker-compose exec db mysql -uroot -proot -Dbiblioteca
```
**Veja**: DOCKER_COMMANDS.md - Banco de Dados

### Entrar no container
```bash
docker-compose exec app sh
```
**Veja**: DOCKER_COMMANDS.md - Acessar Containers

### Fazer backup
```bash
docker-compose exec db mysqldump -uroot -proot biblioteca > backup.sql
```
**Veja**: DOCKER_COMMANDS.md - Backup e Restore

### Resolver problema de permissão (Fedora)
```bash
# Adicionar sufixo :Z aos volumes no docker-compose.yml
# Depois restart
docker-compose down
docker-compose up -d
```
**Veja**: FEDORA_ADVANCED.md - Problemas com SELinux

### Resolver porta bloqueada (Fedora)
```bash
sudo firewall-cmd --permanent --add-port=8000/tcp
sudo firewall-cmd --reload
```
**Veja**: FEDORA_ADVANCED.md - Problemas com Firewall

---

## 📊 Estrutura de Arquivos

```
ManagerLibrary_Laravel/
├── DOCKER_SETUP.md              ← Guia principal
├── DOCKER_COMMANDS.md           ← Referência rápida
├── FEDORA_ADVANCED.md           ← Guia Fedora avançado
├── README_DOCKER.md             ← Este arquivo
│
├── docker-compose.yml           ← Definição dos serviços
├── Dockerfile                   ← Imagem da aplicação
├── docker-entrypoint.sh        ← Script de inicialização
├── docker/                      ← Configurações Docker
│   └── nginx/
│       └── default.conf        ← Config Nginx
│
├── app/                         ← Código Laravel
├── public/                      ← Arquivos públicos
├── storage/                     ← Storage da app
├── bootstrap/                   ← Inicialização
├── database/                    ← Migrations
├── routes/                      ← Rotas
├── resources/                   ← Views
├── tests/                       ← Testes
│
└── composer.json               ← Dependências PHP
```

---

## 🆘 Precisa de Ajuda?

### Começar do Zero
1. Abra **DOCKER_SETUP.md**
2. Encontre sua seção (Windows, Linux ou Fedora)
3. Siga o passo a passo

### Comando Específico
1. Abra **DOCKER_COMMANDS.md**
2. Use Ctrl+F para procurar por palavra-chave
3. Copie e execute o comando

### Problema Técnico
1. Abra **DOCKER_COMMANDS.md** - Seção "Troubleshooting Rápido"
2. Se estiver no Fedora, abra **FEDORA_ADVANCED.md**
3. Procure pelo erro na seção correspondente

### Não encontrou?
- Verifique **FEDORA_ADVANCED.md - Checklist de Diagnóstico**
- Use os comandos de diagnóstico fornecidos
- Colete as informações de diagnóstico e procure em comunidades

---

## 🔗 Referências Externas

- [Docker Documentation](https://docs.docker.com/)
- [Docker Compose Documentation](https://docs.docker.com/compose/)
- [Laravel Documentation](https://laravel.com/docs)
- [Fedora Documentation](https://docs.fedoraproject.org/)
- [SELinux Documentation](https://selinuxproject.org/)

---

## ✅ Checklist Inicial

- [ ] Docker instalado e funcionando
- [ ] Docker Compose instalado e funcionando
- [ ] Repositório clonado
- [ ] `docker-compose up -d` executado
- [ ] Aguardou 15 segundos para inicialização
- [ ] `http://localhost:8000` acessível

Se todos os itens estão marcados ✅, **parabéns!** A aplicação está rodando.

---

## 📝 Notas Importantes

### SELinux (Fedora)
O Fedora usa SELinux para segurança adicional. Isso significa que os volumes do Docker precisam do sufixo `:Z` para funcionar corretamente. **DOCKER_SETUP.md** já configurar isso automaticamente.

### Firewall (Fedora)
Por padrão, o Fedora bloqueia a porta 8000. Use `firewall-cmd` para abrir. Veja **FEDORA_ADVANCED.md - Problemas com Firewall** para detalhes.

### Permissões (Todos os Sistemas)
Certifique-se de que seu usuário está no grupo `docker` no Linux/Fedora. No Windows, execute o PowerShell como Administrador.

---

**Última atualização**: Maio de 2026  
**Versão**: 1.0  
**Mantido por**: ManagerLibrary Team

🚀 **Boa sorte! Divirta-se com Docker!**
