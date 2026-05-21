# 🐳 Guia Completo: Execução da ManagerLibrary via Docker

Documentação completa para executar a aplicação ManagerLibrary em diferentes sistemas operacionais usando Docker e Docker Compose.

---

## 📋 Índice

1. [Pré-requisitos](#pré-requisitos)
2. [Windows](#windows)
3. [Linux (Ubuntu/Debian)](#linux-ubuntudebian)
4. [Fedora (Características Especiais)](#fedora-características-especiais)
5. [Execução da Aplicação](#execução-da-aplicação)
6. [Troubleshooting](#troubleshooting)
7. [Estrutura do Projeto](#estrutura-do-projeto)

---

## 🔧 Pré-requisitos

Antes de começar, você precisa ter:

- **Docker**: Gerenciador de contêineres
- **Docker Compose**: Ferramenta para orquestração de múltiplos contêineres
- **Git** (opcional, para clonar o repositório)
- **Espaço em disco**: Mínimo 2GB livre
- **Acesso à internet**: Para baixar imagens Docker

---

## 🪟 Windows

### 1. Instalação do Docker Desktop

#### Opção A: Instalador Oficial (Recomendado)

1. Acesse [Docker Official Website](https://www.docker.com/products/docker-desktop)
2. Clique em **"Docker Desktop for Windows"**
3. Execute o instalador `.exe` como administrador
4. Durante a instalação, selecione as opções:
   - ✅ "Install required Windows components for WSL 2 backend"
   - ✅ "Add Docker Compose"
5. Reinicie o computador quando solicitado

#### Opção B: Windows Package Manager (Chocolatey)

```powershell
# Abra PowerShell como administrador
choco install docker-desktop -y
```

#### Opção C: Windows Package Manager (Winget)

```powershell
# Windows 11+
winget install Docker.DockerDesktop
```

### 2. Verificar a Instalação

Abra o **PowerShell** ou **cmd** e execute:

```powershell
docker --version
docker-compose --version
```

Você deve ver versões do Docker e Docker Compose.

### 3. Clonar o Repositório

```powershell
# Navegue até o local desejado
cd "C:\Users\SeuUsuario\Desktop"

# Clone o repositório
git clone <url-do-repositorio> ManagerLibrary_Laravel
cd ManagerLibrary_Laravel
```

### 4. Executar a Aplicação

```powershell
# Inicie os containers
docker-compose up -d

# Aguarde 10-15 segundos para inicialização
Start-Sleep -Seconds 15

# Verifique o status
docker-compose ps

# Verifique os logs
docker-compose logs library_web
```

### 5. Acessar a Aplicação

Abra seu navegador e acesse:

```
http://localhost:8000
```

### 6. Parar os Containers

```powershell
docker-compose down
```

### 7. Remover Tudo (Limpeza Completa)

```powershell
# Para e remove containers, volumes e redes
docker-compose down -v

# Remove imagens
docker rmi $(docker images -q)
```

### ⚠️ Problemas Comuns no Windows

| Problema | Solução |
|----------|---------|
| Docker daemon não inicia | Ative Hyper-V em "Painel de Controle" > "Programas" > "Ativar ou desativar recursos do Windows" |
| Porta 8000 já em uso | `netstat -ano \| findstr :8000` para encontrar o processo, depois `taskkill /PID <PID> /F` |
| Permissões negadas | Execute PowerShell como administrador |
| WSL 2 backend não funciona | Ative virtualização no BIOS e instale WSL 2 |

---

## 🐧 Linux (Ubuntu/Debian)

### 1. Instalação do Docker

#### Opção A: Repositório Oficial (Recomendado)

```bash
# Atualize o sistema
sudo apt-get update
sudo apt-get upgrade -y

# Instale dependências
sudo apt-get install -y ca-certificates curl gnupg lsb-release

# Adicione a chave GPG do Docker
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | \
  sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg

# Configure o repositório estável
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] \
  https://download.docker.com/linux/ubuntu \
  $(lsb_release -cs) stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

# Instale Docker
sudo apt-get update
sudo apt-get install -y docker-ce docker-ce-cli containerd.io docker-compose-plugin
```

#### Opção B: Script de Conveniência

```bash
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
```

### 2. Instalação do Docker Compose

```bash
# Instale Docker Compose v2 (recomendado)
sudo apt-get install -y docker-compose-plugin

# Ou instale Docker Compose v1 (legado)
sudo apt-get install -y docker-compose
```

### 3. Configurar Permissões (Não executar como sudo)

```bash
# Crie o grupo docker
sudo groupadd docker

# Adicione seu usuário ao grupo
sudo usermod -aG docker $USER

# Ative as alterações
newgrp docker

# Verifique se funciona sem sudo
docker run hello-world
```

### 4. Verificar a Instalação

```bash
docker --version
docker-compose --version
```

### 5. Clonar o Repositório

```bash
# Navegue até o local desejado
cd ~/Documentos

# Clone o repositório
git clone <url-do-repositorio> ManagerLibrary_Laravel
cd ManagerLibrary_Laravel
```

### 6. Executar a Aplicação

```bash
# Inicie os containers
docker-compose up -d

# Aguarde 10-15 segundos
sleep 15

# Verifique o status
docker-compose ps

# Verifique os logs
docker-compose logs library_web
```

### 7. Acessar a Aplicação

Abra seu navegador e acesse:

```
http://localhost:8000
```

### 8. Parar os Containers

```bash
docker-compose down
```

### 9. Remover Tudo (Limpeza Completa)

```bash
# Para e remove containers, volumes e redes
docker-compose down -v

# Remove imagens
docker rmi $(docker images -q)
```

### ⚠️ Problemas Comuns no Ubuntu/Debian

| Problema | Solução |
|----------|---------|
| Permissão negada | Use `sudo` ou configure permissões como na seção "Configurar Permissões" |
| Porta 8000 já em uso | `sudo lsof -i :8000` para encontrar, depois `kill -9 <PID>` |
| Docker daemon não inicia | `sudo systemctl restart docker` |
| Conflito de rede | `docker network prune` e `docker-compose down -v` |

---

## 🎩 Fedora (Características Especiais)

O Fedora possui algumas características e comandos ligeiramente diferentes do Ubuntu/Debian. Aqui estão as instruções específicas:

### 1. Instalação do Docker e Docker Compose

#### Opção A: DNF (Gerenciador de pacotes do Fedora)

```bash
# Atualize o sistema
sudo dnf upgrade -y

# Instale Docker
sudo dnf install -y docker

# Instale Docker Compose
sudo dnf install -y docker-compose

# Instale podman-docker (compatibilidade com Docker CLI)
sudo dnf install -y podman-docker
```

#### Opção B: Repositório Oficial do Docker

```bash
# Configure o repositório do Docker para Fedora
sudo dnf -y install dnf-plugins-core
sudo dnf config-manager --add-repo https://download.docker.com/linux/fedora/docker-ce.repo

# Instale Docker
sudo dnf install -y docker-ce docker-ce-cli containerd.io docker-compose-plugin

# Verifique a instalação
docker --version
docker-compose --version
```

### 2. Habilitar e Iniciar o Docker

```bash
# Habilite Docker para iniciar automaticamente
sudo systemctl enable docker

# Inicie o Docker
sudo systemctl start docker

# Verifique se está rodando
sudo systemctl status docker
```

### 3. Configurar Permissões (Importante no Fedora!)

O Fedora usa **SELinux** por padrão, que é mais restritivo que o AppArmor do Ubuntu.

```bash
# Crie o grupo docker
sudo groupadd docker

# Adicione seu usuário ao grupo
sudo usermod -aG docker $USER

# Ative as alterações (IMPORTANTE no Fedora)
newgrp docker

# Configure SELinux para permitir docker
sudo semanage fcontext -a -t container_file_t "/home/$(whoami)(/.*)?"
sudo restorecon -R /home/$(whoami)

# Verifique se funciona sem sudo
docker run hello-world
```

### 4. Características Especiais do Fedora

#### A. SELinux e Volumes com Sufixo `:Z`

**O que é?** Fedora usa SELinux, que restringe o acesso aos arquivos. O sufixo `:Z` permite que containers acessem volumes corretamente.

No arquivo `docker-compose.yml`, note as linhas com `:Z`:

```yaml
volumes:
  - .:/var/www:Z                                    # ← Sufixo :Z
  - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf:Z
```

#### B. Firewall do Fedora

Se você está enfrentando problemas de conectividade:

```bash
# Abra a porta 8000 no firewall
sudo firewall-cmd --permanent --add-port=8000/tcp
sudo firewall-cmd --reload

# Verifique as portas abertas
sudo firewall-cmd --list-all
```

#### C. Diretório de Volumes

Fedora pode ter permissões diferentes. Se encontrar problemas:

```bash
# Defina permissões corretas
sudo chown -R $(id -u):$(id -g) ~/ManagerLibrary_Laravel
chmod -R 755 ~/ManagerLibrary_Laravel
```

### 5. Clonar o Repositório

```bash
# Navegue até o local desejado
cd ~/Documentos

# Clone o repositório
git clone <url-do-repositorio> ManagerLibrary_Laravel
cd ManagerLibrary_Laravel
```

### 6. Executar a Aplicação no Fedora

```bash
# Inicie os containers
docker-compose up -d

# Aguarde 10-15 segundos
sleep 15

# Verifique o status
docker-compose ps

# Verifique os logs
docker-compose logs library_web
```

### 7. Acessar a Aplicação

Abra seu navegador e acesse:

```
http://localhost:8000
```

### 8. Parar os Containers

```bash
docker-compose down
```

### 9. Remover Tudo (Limpeza Completa)

```bash
# Para e remove containers, volumes e redes
docker-compose down -v

# Remove imagens
docker rmi $(docker images -q)
```

### 🔴 Problemas Comuns no Fedora

| Problema | Solução |
|----------|---------|
| SELinux nega acesso | Adicione sufixo `:Z` aos volumes: `.:/var/www:Z` |
| Conectividade do firewall | `sudo firewall-cmd --permanent --add-port=8000/tcp` |
| Porta 8000 bloqueada | `sudo firewall-cmd --list-all` e verifique as portas |
| Permissão de volumes | Use `sudo chown -R $(id -u):$(id -g) .` no diretório do projeto |
| Docker não inicia | `sudo systemctl restart docker` e `sudo systemctl status docker` |
| Grupo docker sem permissão | Faça logout e login ou execute `newgrp docker` |
| Conflito com Podman | Se tiver Podman, use `docker` normalmente (podman-docker fornece compatibilidade) |

---

## ▶️ Execução da Aplicação

### Iniciar os Containers

```bash
# Windows (PowerShell)
docker-compose up -d

# Linux / Fedora
docker-compose up -d
```

### Verificar o Status

```bash
# Windows (PowerShell)
docker-compose ps

# Linux / Fedora
docker-compose ps
```

### Visualizar Logs

```bash
# Todos os containers
docker-compose logs

# Apenas o container web
docker-compose logs library_web

# Apenas o container app
docker-compose logs library_app

# Apenas o container db
docker-compose logs library_db

# Logs em tempo real
docker-compose logs -f library_web
```

### Acessar a Aplicação

Em qualquer sistema, abra seu navegador e acesse:

```
http://localhost:8000
```

### Parar os Containers

```bash
# Parar sem remover
docker-compose stop

# Parar e remover
docker-compose down

# Parar e remover volumes (cuidado: deleta o banco de dados!)
docker-compose down -v
```

### Reiniciar os Containers

```bash
docker-compose restart
```

### Executar Comandos Dentro do Container

```bash
# Entrar no shell do container app
docker-compose exec app sh

# Executar artisan dentro do container
docker-compose exec app php artisan migrate

# Executar composer dentro do container
docker-compose exec app composer install

# Sair do container
exit
```

---

## 🔧 Troubleshooting

### Problema: "Permission denied" no Fedora

**Causa**: SELinux está bloqueando acesso aos volumes.

**Solução**:

```bash
# Adicione contexto SELinux correto
sudo semanage fcontext -a -t container_file_t "$(pwd)(/.*)?"
sudo restorecon -R .

# Ou use o sufixo :Z no docker-compose.yml
volumes:
  - .:/var/www:Z
```

### Problema: Porta 8000 já em uso

**Windows**:
```powershell
netstat -ano | findstr :8000
taskkill /PID <PID> /F
```

**Linux / Fedora**:
```bash
lsof -i :8000
kill -9 <PID>
```

### Problema: Docker daemon não inicia

**Windows**:
- Verifique se Hyper-V está habilitado
- Reinicie o Docker Desktop
- Se necessário, execute: `wsl --shutdown` e reinicie

**Linux / Fedora**:
```bash
sudo systemctl restart docker
sudo systemctl status docker
```

### Problema: Erro de banco de dados ao iniciar

```bash
# Limpe tudo e recrie
docker-compose down -v
docker-compose up -d

# Aguarde 20 segundos para o MySQL inicializar
sleep 20

# Verifique os logs
docker-compose logs library_app
```

### Problema: Nginx respondendo com 404

**Causa**: Permissões incorretas no diretório `/var/www/public`.

**Solução**: O docker-entrypoint.sh já configura isso automaticamente. Se persistir:

```bash
docker-compose exec app chmod -R 755 /var/www/public
docker-compose restart library_web
```

### Problema: Conectar ao banco de dados

Use os seguintes dados:

```
Host: localhost (ou 127.0.0.1)
Porta: 3306
Usuário: root
Senha: root
Database: biblioteca
```

Ou dentro do container:

```bash
docker-compose exec db mysql -uroot -proot -Dbiblioteca
```

---

## 📁 Estrutura do Projeto

```
ManagerLibrary_Laravel/
├── app/                          # Código da aplicação Laravel
├── bootstrap/                    # Arquivos de inicialização
├── config/                       # Arquivos de configuração
├── database/                     # Migrations e seeds
├── docker/
│   ├── nginx/
│   │   └── default.conf         # Configuração do Nginx
│   └── ...
├── docker-compose.yml           # Orquestração de containers
├── Dockerfile                   # Definição da imagem Docker
├── docker-entrypoint.sh        # Script de inicialização
├── public/                      # Arquivos públicos (raiz do web)
├── resources/                   # Views e assets
├── routes/                      # Rotas da aplicação
├── storage/                     # Arquivos de storage
├── tests/                       # Testes automatizados
├── vendor/                      # Dependências PHP (Composer)
├── .env                         # Variáveis de ambiente
├── .env.example                 # Exemplo de variáveis
├── docker-compose.yml           # Definição dos serviços
└── README.md                    # Documentação geral
```

### Arquivos Docker Explicados

#### `docker-compose.yml`

Define os três serviços:

- **app**: Container PHP-FPM (processa requisições PHP)
- **web**: Container Nginx (servidor web, porta 8000)
- **db**: Container MySQL (banco de dados, porta 3306)

**Nota importante**: A linha `version: '3.8'` foi removida por ser obsoleta em versões recentes.

#### `Dockerfile`

Define a imagem Docker para o container `app`:

- Base: `php:8.4-fpm` (PHP 8.4 com FPM)
- Instala dependências do sistema (libpng, MySQL client, etc.)
- Instala extensões PHP (PDO, MySQL, ZIP, GD, etc.)
- Copia Composer e o script de entrada
- Expõe porta 9000 (FPM)

#### `docker-entrypoint.sh`

Script executado ao iniciar o container `app`:

- Instala dependências do Composer (se necessário)
- Cria arquivo `.env` (se necessário)
- Aguarda o MySQL estar pronto
- Executa migrations
- **Configura permissões corretas para web e storage** ← Importante!
- Inicia o PHP-FPM

---

## 📝 Próximas Etapas

Após iniciar a aplicação:

1. **Verifique os logs**: `docker-compose logs -f`
2. **Acesse a aplicação**: Abra `http://localhost:8000` no navegador
3. **Explore o banco de dados**: Conecte via MySQL (localhost:3306)
4. **Personalize a configuração**: Edite `.env` conforme necessário
5. **Faça backup dos dados**: Use `docker-compose exec db mysqldump -uroot -proot biblioteca > backup.sql`

---

## 📞 Suporte Adicional

Se encontrar problemas não listados aqui:

1. Verifique os logs: `docker-compose logs`
2. Verifique o status: `docker-compose ps`
3. Reinicie os containers: `docker-compose restart`
4. Se necessário, recrie tudo: `docker-compose down -v && docker-compose up -d`

---

**Última atualização**: Maio de 2026  
**Versão**: 1.0  
**Mantido por**: ManagerLibrary Team
