# Remove Fundo — Remoção de Fundo Grátis

Site gratuito para remover fundos de imagens diretamente no navegador. **100% gratuito e privado** — suas imagens nunca saem do seu dispositivo.

## Requisitos

- PHP 7.4 ou superior

## Como usar

1. Inicie o servidor PHP na pasta do projeto:
   ```bash
   php -S localhost:8000
   ```

2. Abra no navegador: http://localhost:8000

3. Arraste uma imagem ou clique para selecionar.

4. Aguarde o processamento (a primeira vez demora mais para baixar o modelo).

5. Baixe a imagem sem fundo em PNG.

## Tecnologias

- **PHP** — servidor
- **@imgly/background-removal** (via ESM CDN) — remoção de fundo no navegador

## Hospedagem

Para hospedar em Apache, coloque os arquivos na pasta `public_html` ou `www` do seu provedor. O `index.php` será servido automaticamente.
