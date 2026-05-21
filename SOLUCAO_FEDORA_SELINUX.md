# 🎯 Solução: SELinux Permission Denied no Fedora

## ✅ Status: RESOLVIDO

A aplicação está funcionando corretamente!

---

## 📋 Problema Original

```
library_web | 2026/05/21 02:11:52 [crit] 29#29: *1 stat() "/var/www/public/" failed (13: Permission denied)
```

**O que significa:**
- Nginx tentava acessar o diretório `/var/www/public/`
- SELinux (Fedora) bloqueava o acesso
- Resultado: Erro 404 com permission denied

---

## 🔍 Análise da Causa

### Três camadas de permissão no Docker/Fedora:

1. **Permissões Unix (chmod)** ✅
   - Diretório public: 755 (leitura permitida)
   - Arquivo index.php: 644 (leitura permitida)
   - Status: OK

2. **Volumes Docker** ✅ (com :Z)
   - Diretório compartilhado corretamente
   - Sufixo :Z presente
   - Status: Configurado

3. **SELinux Context** ❌ (O CULPADO)
   - Contexto isolado (:Z)
   - Nginx não tinha permissão para ler container_file_t
   - Status: BLOQUEADO

### Diferença: :Z vs :z

```
:Z (maiúscula)
├─ Contexto isolado para cada container
├─ Máximo isolamento/segurança
├─ MAS: Impede leitura compartilhada entre containers
└─ Resultado: Nginx não conseguia ler volume do app

:z (minúscula)
├─ Contexto compartilhado entre containers
├─ Menos isolamento
├─ Permite leitura e escrita compartilhada
└─ Resultado: Nginx consegue ler o volume do app ✅
```

---

## ✅ Solução Implementada

### O que foi mudado:

**Arquivo: `docker-compose.yml`**

```yaml
# ANTES (com :Z)
app:
  volumes:
    - .:/var/www:Z

web:
  volumes:
    - .:/var/www:Z
    - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf:Z

# DEPOIS (com :z)
app:
  volumes:
    - .:/var/www:z

web:
  volumes:
    - .:/var/www:z
    - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf:z
```

**Mudanças específicas:**
- Linha 11: `:Z` → `:z`
- Linha 25: `:Z` → `:z`
- Linha 26: `:Z` → `:z`

### Passos realizados:

```bash
# 1. Parar containers
docker-compose down

# 2. Editar docker-compose.yml (mudar :Z para :z)
vim docker-compose.yml

# 3. Reiniciar containers
docker-compose up -d

# 4. Teste
curl http://localhost:8000/
```

---

## 📊 Resultado

### Antes (Erro):
```
HTTP/1.1 404 Not Found
[crit] stat() "/var/www/public/" failed (13: Permission denied)
❌ ERRO
```

### Depois (Funcionando):
```
HTTP/1.1 302 Found
Location: http://localhost:8000/books
Set-Cookie: XSRF-TOKEN=...
Set-Cookie: laravel-session=...
✅ SUCESSO
```

---

## 🚀 Aplicação Operacional

✅ **Nginx (web)** - Respondendo na porta 8000
✅ **PHP-FPM (app)** - Pronto para requisições
✅ **MySQL (db)** - Operacional na porta 3306
✅ **Laravel** - Funcionando corretamente

---

## 🌐 Acessar a Aplicação

```
http://localhost:8000
```

Você será redirecionado para:
```
http://localhost:8000/books
```

---

## 🔐 Considerações de Segurança

### :z (Atual)
- ✅ Funciona bem para desenvolvimento
- ✅ Permite comunicação entre containers
- ⚠️ Menos isolado que :Z
- ✅ Aceitável para ambiente local

### Para Produção
Se precisar de mais isolamento em produção:

**Opção 1:** Voltar para :Z + configurar SELinux
```bash
sudo semanage fcontext -a -t svirt_sandbox_file_t "/caminho/projeto(/.*)?"
sudo restorecon -R /caminho/projeto/
```

**Opção 2:** Usar :Z + modo permissive para container_t
```bash
sudo semanage permissive -a container_t
```

**Opção 3:** Manter :z (desenvolvimento = não é crítico)

---

## 🔧 Comandos Úteis

```bash
# Verificar status
docker-compose ps

# Ver logs
docker-compose logs library_web

# Testar acesso
curl -I http://localhost:8000

# Entrar no container
docker-compose exec app sh

# Parar tudo
docker-compose down

# Reiniciar
docker-compose up -d
```

---

## 📚 Referências

- [Docker Volumes com SELinux](https://docs.docker.com/storage/bind-mounts/#configure-selinux-labels)
- [Fedora SELinux Documentation](https://docs.fedoraproject.org/en-US/fedora/latest/system-administrators-guide/sec-working_with_selinux/)
- [Docker-Compose Documentation](https://docs.docker.com/compose/)

---

## ✨ Resumo

| Item | Status |
|------|--------|
| Problema | ✅ Resolvido |
| Aplicação | ✅ Funcionando |
| Containers | ✅ Rodando |
| Acesso Web | ✅ Disponível |
| SELinux | ✅ Configurado |
| Documentação | ✅ Atualizada |

**Data de Resolução:** 21 de Maio de 2026
**Sistema:** Fedora com Docker e Docker Compose
**Solução:** Mudar sufixo SELinux de :Z para :z

🎉 **Tudo pronto para desenvolver!**
