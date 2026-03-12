<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Remove Fundo | Remoção de Fundo Grátis</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <style>
    :root {
      --bg-dark: #0d0f14;
      --bg-card: #161a22;
      --bg-elevated: #1e232d;
      --accent: #00d4aa;
      --accent-dim: rgba(0, 212, 170, 0.15);
      --text: #e8ecf4;
      --text-muted: #8b95a8;
      --border: #2a3142;
      --radius: 16px;
      --radius-sm: 10px;
      --font-sans: 'Outfit', system-ui, sans-serif;
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html { font-size: 16px; scroll-behavior: smooth; }
    body {
      font-family: var(--font-sans);
      background: var(--bg-dark);
      color: var(--text);
      min-height: 100vh;
      line-height: 1.6;
      background-image:
        radial-gradient(ellipse 80% 50% at 50% -20%, var(--accent-dim), transparent),
        radial-gradient(ellipse 60% 40% at 100% 100%, rgba(0, 100, 200, 0.08), transparent);
    }
    #app { max-width: 1100px; margin: 0 auto; padding: 2rem 1.5rem; }
    .header { text-align: center; margin-bottom: 3rem; }
    .logo { display: flex; flex-direction: column; align-items: center; gap: 0.5rem; }
    .logo-icon { font-size: 3rem; filter: drop-shadow(0 0 20px var(--accent-dim)); }
    .logo h1 {
      font-size: 2.25rem; font-weight: 700; letter-spacing: -0.02em;
      background: linear-gradient(135deg, #fff 0%, var(--accent) 100%);
      -webkit-background-clip: text; -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    .tagline { color: var(--text-muted); font-size: 0.95rem; }
    .dropzone {
      border: 2px dashed var(--border); border-radius: var(--radius);
      padding: 4rem 2rem; text-align: center; cursor: pointer;
      transition: all 0.25s ease; background: var(--bg-card);
    }
    .dropzone:hover, .dropzone.dragover {
      border-color: var(--accent); background: var(--accent-dim);
    }
    .dropzone-content { display: flex; flex-direction: column; align-items: center; gap: 1rem; }
    .dropzone-icon { font-size: 4rem; opacity: 0.8; }
    .dropzone h2 { font-size: 1.35rem; font-weight: 600; }
    .dropzone p { color: var(--text-muted); font-size: 0.95rem; }
    .file-input { display: none; }
    .processing {
      display: flex; flex-direction: column; align-items: center; justify-content: center;
      gap: 1.5rem; padding: 4rem 2rem; min-height: 320px;
    }
    .spinner {
      width: 56px; height: 56px; border: 3px solid var(--border);
      border-top-color: var(--accent); border-radius: 50%;
      animation: spin 0.9s linear infinite;
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    .processing h2 { font-size: 1.25rem; font-weight: 500; }
    .processing-hint { color: var(--text-muted); font-size: 0.9rem; max-width: 380px; text-align: center; }
    .gallery { display: flex; flex-direction: column; gap: 2rem; }
    .comparison { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
    @media (max-width: 700px) { .comparison { grid-template-columns: 1fr; } }
    .image-card {
      background: var(--bg-card); border-radius: var(--radius);
      padding: 1.25rem; border: 1px solid var(--border);
    }
    .image-card h3 { font-size: 0.9rem; font-weight: 600; margin-bottom: 0.75rem; color: var(--text-muted); }
    .image-card.result { border-color: var(--accent); box-shadow: 0 0 0 1px var(--accent-dim); }
    .preview-img {
      width: 100%; height: auto; max-height: 360px;
      object-fit: contain; border-radius: var(--radius-sm); display: block;
    }
    .transparent-bg {
      background: linear-gradient(45deg, #2a2a2a 25%, transparent 25%),
        linear-gradient(-45deg, #2a2a2a 25%, transparent 25%),
        linear-gradient(45deg, transparent 75%, #2a2a2a 75%),
        linear-gradient(-45deg, transparent 75%, #2a2a2a 75%);
      background-size: 20px 20px;
      background-position: 0 0, 0 10px, 10px -10px, -10px 0;
      background-color: #1a1a1a;
    }
    .actions { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }
    .btn {
      font-family: var(--font-sans); font-size: 1rem; font-weight: 500;
      padding: 0.9rem 1.75rem; border-radius: var(--radius-sm);
      border: none; cursor: pointer; transition: all 0.2s ease;
    }
    .btn-primary { background: var(--accent); color: var(--bg-dark); }
    .btn-primary:hover { background: #00e6b8; transform: translateY(-1px); }
    .btn-secondary { background: var(--bg-elevated); color: var(--text); border: 1px solid var(--border); }
    .btn-secondary:hover { background: var(--border); border-color: var(--text-muted); }
  </style>
</head>
<body>
  <div id="app"></div>
  <script type="module">
    const state = { originalImage: null, resultBlob: null, resultUrl: null, isProcessing: false };

    function createElement(tag, attrs = {}, children = []) {
      const el = document.createElement(tag);
      Object.entries(attrs).forEach(([key, value]) => {
        if (key === 'className') el.className = value;
        else if (key === 'textContent') el.textContent = value;
        else if (key === 'onclick') el.onclick = value;
        else if (key === 'onchange') el.onchange = value;
        else if (key.startsWith('on')) el.addEventListener(key.slice(2).toLowerCase(), value);
        else if (key === 'style' && typeof value === 'object') Object.assign(el.style, value);
        else if (value != null) el.setAttribute(key, value);
      });
      children.forEach(child => {
        if (typeof child === 'string') el.appendChild(document.createTextNode(child));
        else if (child) el.appendChild(child);
      });
      return el;
    }

    function render() {
      const app = document.getElementById('app');
      app.innerHTML = '';
      const header = createElement('header', { className: 'header' }, [
        createElement('div', { className: 'logo' }, [
          createElement('span', { className: 'logo-icon' }, ['✂️']),
          createElement('h1', { textContent: 'Remove Fundo' }),
          createElement('p', { className: 'tagline' }, ['Remoção de fundo 100% gratuita e privada']),
        ]),
      ]);
      const main = createElement('main', { className: 'main' });

      if (!state.originalImage && !state.isProcessing) {
        const dropzone = createElement('div', { className: 'dropzone', id: 'dropzone' }, [
          createElement('div', { className: 'dropzone-content' }, [
            createElement('div', { className: 'dropzone-icon' }, ['📷']),
            createElement('h2', { textContent: 'Arraste sua imagem aqui' }),
            createElement('p', { textContent: 'ou clique para selecionar' }),
            createElement('input', { type: 'file', id: 'file-input', accept: 'image/*', className: 'file-input' }),
          ]),
        ]);
        main.appendChild(dropzone);
      } else if (state.isProcessing) {
        const loader = createElement('div', { className: 'processing' }, [
          createElement('div', { className: 'spinner' }),
          createElement('h2', { textContent: 'Removendo fundo...' }),
          createElement('p', { className: 'processing-hint' }, [
            'A primeira vez pode demorar um pouco enquanto os modelos são baixados. Suas imagens ficam apenas no seu dispositivo!',
          ]),
        ]);
        main.appendChild(loader);
      } else {
        const gallery = createElement('div', { className: 'gallery' }, [
          createElement('div', { className: 'comparison' }, [
            createElement('div', { className: 'image-card' }, [
              createElement('h3', { textContent: 'Original' }),
              createElement('img', { src: state.originalImage, alt: 'Imagem original', className: 'preview-img' }),
            ]),
            createElement('div', { className: 'image-card result' }, [
              createElement('h3', { textContent: 'Sem fundo' }),
              createElement('img', { src: state.resultUrl || '', alt: 'Imagem sem fundo', className: 'preview-img transparent-bg' }),
            ]),
          ]),
          createElement('div', { className: 'actions' }, [
            createElement('button', { className: 'btn btn-primary', textContent: '⬇️ Baixar PNG', onclick: () => downloadResult('png') }),
            createElement('button', { className: 'btn btn-secondary', textContent: '🔄 Nova imagem', onclick: reset }),
          ]),
        ]);
        main.appendChild(gallery);
      }

      app.appendChild(header);
      app.appendChild(main);
      if (!state.originalImage && !state.isProcessing) setupDropzone();
    }

    function setupDropzone() {
      const dropzone = document.getElementById('dropzone');
      const input = document.getElementById('file-input');
      if (!dropzone || !input) return;
      const handleFile = (file) => {
        if (!file?.type?.startsWith('image/')) return;
        state.originalImage = URL.createObjectURL(file);
        state.resultBlob = null;
        state.isProcessing = true;
        render();
        processImage(file);
      };
      dropzone.addEventListener('click', () => input.click());
      dropzone.addEventListener('dragover', (e) => { e.preventDefault(); dropzone.classList.add('dragover'); });
      dropzone.addEventListener('dragleave', () => dropzone.classList.remove('dragover'));
      dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.classList.remove('dragover');
        const file = e.dataTransfer?.files?.[0];
        if (file) handleFile(file);
      });
      input.addEventListener('change', (e) => {
        const file = e.target?.files?.[0];
        if (file) handleFile(file);
      });
    }

    async function processImage(file) {
      try {
        const { removeBackground } = await import('https://esm.sh/@imgly/background-removal');
        const blob = await removeBackground(file, {
          debug: false,
          progress: (key, current, total) => {
            if (total > 0) {
              const pct = Math.round((current / total) * 100);
              const hint = document.querySelector('.processing-hint');
              if (hint) hint.textContent = `Baixando modelo: ${pct}%`;
            }
          },
        });
        state.resultBlob = blob;
        state.resultUrl = URL.createObjectURL(blob);
      } catch (err) {
        console.error(err);
        alert('Erro ao remover o fundo. Tente outra imagem ou verifique se o formato é suportado.');
      } finally {
        state.isProcessing = false;
        render();
      }
    }

    function downloadResult() {
      if (!state.resultBlob) return;
      const a = document.createElement('a');
      a.href = URL.createObjectURL(state.resultBlob);
      a.download = 'imagem-sem-fundo.png';
      a.click();
      URL.revokeObjectURL(a.href);
    }

    function reset() {
      if (state.originalImage) URL.revokeObjectURL(state.originalImage);
      if (state.resultUrl) URL.revokeObjectURL(state.resultUrl);
      state.originalImage = null;
      state.resultBlob = null;
      state.resultUrl = null;
      state.isProcessing = false;
      render();
    }

    render();
  </script>
</body>
</html>
