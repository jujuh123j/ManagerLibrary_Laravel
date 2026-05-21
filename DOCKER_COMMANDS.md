# 📚 Referência Rápida: Comandos Docker

Guia rápido de comandos Docker e Docker Compose para desenvolvimento.

---

## 🚀 Comandos Essenciais

### Iniciar / Parar Aplicação

```bash
# Iniciar containers em background
docker-compose up -d

# Parar containers (mantém dados)
docker-compose stop

# Parar e remover containers
docker-compose down

# Parar e remover tudo, incluindo volumes (⚠️ Deleta banco de dados!)
docker-compose down -v

# Reiniciar containers
docker-compose restart

# Reconstruir imagens
docker-compose build

# Iniciar com rebuild
docker-compose up -d --build
```

---

## 📊 Monitoramento

### Ver Status dos Containers

```bash
# Listar containers da aplicação
docker-compose ps

# Listar todos os containers no sistema
docker ps -a

# Listar imagens Docker
docker images
```

### Visualizar Logs

```bash
# Logs de todos os containers
docker-compose logs

# Logs apenas do web (nginx)
docker-compose logs library_web

# Logs apenas do app (PHP)
docker-compose logs library_app

# Logs apenas do db (MySQL)
docker-compose logs library_db

# Logs em tempo real (follow)
docker-compose logs -f

# Últimas 50 linhas
docker-compose logs --tail=50

# Logs desde os últimos 5 minutos
docker-compose logs --since=5m
```

### Verificar Recursos

```bash
# Ver uso de CPU e memória
docker stats

# Detalhes de um container específico
docker inspect library_web

# Listar volumes
docker volume ls
```

---

## 🔧 Acessar Containers

### Entrar no Shell

```bash
# Container app (PHP-FPM)
docker-compose exec app sh

# Container web (Nginx)
docker-compose exec web sh

# Container db (MySQL)
docker-compose exec db bash

# Sair do container
exit
```

### Executar Comandos no Container

```bash
# Laravel Artisan
docker-compose exec app php artisan --version
docker-compose exec app php artisan migrate
docker-compose exec app php artisan tinker
docker-compose exec app php artisan queue:work

# Composer
docker-compose exec app composer install
docker-compose exec app composer update
docker-compose exec app composer require <package>

# NPM
docker-compose exec app npm install
docker-compose exec app npm run dev

# MySQL
docker-compose exec db mysql -uroot -proot -Dbiblioteca
docker-compose exec db mysql -uroot -proot -Dbiblioteca -e "SHOW TABLES;"

# Ver versões
docker-compose exec app php -v
docker-compose exec app node -v
docker-compose exec db mysql --version
```

---

## 🗄️ Banco de Dados

### Acessar MySQL

```bash
# Conectar ao MySQL interativamente
docker-compose exec db mysql -uroot -proot -Dbiblioteca

# Executar comando direto
docker-compose exec db mysql -uroot -proot -Dbiblioteca -e "SELECT * FROM users;"

# Listar bancos de dados
docker-compose exec db mysql -uroot -proot -e "SHOW DATABASES;"

# Criar backup
docker-compose exec db mysqldump -uroot -proot biblioteca > backup.sql

# Restaurar backup
docker-compose exec -T db mysql -uroot -proot biblioteca < backup.sql

# Ver estrutura de uma tabela
docker-compose exec db mysql -uroot -proot -Dbiblioteca -e "DESCRIBE usuarios;"
```

### Dados de Conexão

```
Host: localhost
Porta: 3306
Usuário: root
Senha: root
Database: biblioteca
```

---

## 📁 Gerenciar Volumes e Dados

### Volumes

```bash
# Listar volumes
docker volume ls

# Inspecionar volume
docker volume inspect <volume_name>

# Remover volume
docker volume rm <volume_name>

# Remover volumes não utilizados
docker volume prune

# Remover tudo
docker-compose down -v
```

### Copiar Arquivos

```bash
# Copiar arquivo DO container PARA host
docker cp library_app:/var/www/storage/logs/laravel.log ./laravel.log

# Copiar arquivo DO host PARA container
docker cp ./arquivo.txt library_app:/var/www/

# Copiar diretório
docker cp library_app:/var/www/storage ./storage_backup
```

---

## 🧹 Limpeza e Manutenção

### Remover Recursos Não Utilizados

```bash
# Remover containers parados
docker container prune

# Remover imagens não utilizadas
docker image prune

# Remover volumes não utilizados
docker volume prune

# Remover redes não utilizadas
docker network prune

# Remover TUDO não utilizado
docker system prune -a --volumes
```

### Rebuild Completo

```bash
# Parar e remover tudo
docker-compose down -v

# Remover imagens
docker rmi $(docker images -q)

# Reconstruir do zero
docker-compose build --no-cache
docker-compose up -d
```

---

## 🚨 Troubleshooting Rápido

### Container não inicia

```bash
# Ver erro detalhado
docker-compose logs library_app

# Reconstruir container
docker-compose build app
docker-compose up -d

# Se persistir, recrie tudo
docker-compose down -v
docker-compose up -d --build
```

### Permissões negadas

```bash
# No container app
docker-compose exec app chmod -R 755 /var/www/public
docker-compose exec app chmod -R 775 /var/www/storage

# Restart
docker-compose restart library_web
```

### Porta 8000 já em uso

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

### MySQL não conecta

```bash
# Verificar se MySQL está rodando
docker-compose ps library_db

# Ver logs do MySQL
docker-compose logs library_db

# Reiniciar MySQL
docker-compose restart library_db

# Aguarde 10 segundos e teste
sleep 10
docker-compose exec db mysql -uroot -proot -e "SELECT 1;"
```

---

## 🔑 Variáveis de Ambiente

### Editando .env

```bash
# Copiar exemplo
cp .env.example .env

# Editar arquivo
docker-compose exec app nano /var/www/.env

# Recarregar configuração
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan config:clear
```

### Arquivo .env Padrão

```
APP_NAME=ManagerLibrary
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=biblioteca
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync
```

---

## 🐳 Redes Docker

### Ver Redes

```bash
# Listar redes
docker network ls

# Inspecionar rede
docker network inspect <network_name>

# Verificar conectividade entre containers
docker-compose exec app ping db
```

---

## 📈 Performance

### Otimizar Volumes (Especialmente Fedora)

```bash
# Adicionar contexto SELinux (Fedora)
sudo semanage fcontext -a -t container_file_t "$(pwd)(/.*)?"
sudo restorecon -R .

# Usar sufixo :Z no docker-compose.yml
volumes:
  - .:/var/www:Z
```

### Aumentar Limites de Recursos

Edite `docker-compose.yml`:

```yaml
services:
  app:
    # ... outras configurações
    deploy:
      resources:
        limits:
          cpus: '1'
          memory: 512M
        reservations:
          cpus: '0.5'
          memory: 256M
```

---

## 🔄 Exemplo de Fluxo Completo

```bash
# 1. Iniciar aplicação
docker-compose up -d

# 2. Aguardar inicialização
sleep 15

# 3. Verificar status
docker-compose ps

# 4. Ver logs
docker-compose logs library_app

# 5. Entrar no container
docker-compose exec app sh

# 6. Dentro do container
cd /var/www
php artisan tinker

# 7. Testar banco de dados
docker-compose exec db mysql -uroot -proot -Dbiblioteca

# 8. Acessar aplicação
# Abrir navegador: http://localhost:8000

# 9. Parar quando terminar
docker-compose down
```

---

## 💾 Backup e Restore

### Fazer Backup Completo

```bash
# Backup do banco de dados
docker-compose exec db mysqldump -uroot -proot biblioteca > backup_$(date +%Y%m%d_%H%M%S).sql

# Backup do storage
docker cp library_app:/var/www/storage storage_backup_$(date +%Y%m%d_%H%M%S)

# Compactar tudo
tar -czf backup_complete_$(date +%Y%m%d_%H%M%S).tar.gz backup*.sql storage_backup*
```

### Restaurar Backup

```bash
# Restaurar banco de dados
docker-compose exec -T db mysql -uroot -proot biblioteca < backup_20260520_120000.sql

# Restaurar storage
docker cp storage_backup_20260520_120000/. library_app:/var/www/storage

# Restaurar permissões
docker-compose exec app chmod -R 775 /var/www/storage
```

---

## 🎓 Referência Rápida por Sistema

### Windows (PowerShell)

```powershell
# Iniciar
docker-compose up -d

# Status
docker-compose ps

# Logs
docker-compose logs -f library_web

# Parar
docker-compose down

# Entrar no container
docker-compose exec app sh

# Backup DB
docker-compose exec db mysqldump -uroot -proot biblioteca | Out-File backup.sql -Encoding UTF8
```

### Linux / Fedora (Bash)

```bash
# Iniciar
docker-compose up -d

# Status
docker-compose ps

# Logs
docker-compose logs -f library_web

# Parar
docker-compose down

# Entrar no container
docker-compose exec app sh

# Backup DB
docker-compose exec db mysqldump -uroot -proot biblioteca > backup.sql
```

---

## 📖 Recursos Adicionais

- [Docker Documentation](https://docs.docker.com/)
- [Docker Compose Documentation](https://docs.docker.com/compose/)
- [Laravel Documentation](https://laravel.com/docs)
- [PHP-FPM Documentation](https://www.php.net/manual/en/install.fpm.php)

---

**Última atualização**: Maio de 2026  
**Versão**: 1.0
