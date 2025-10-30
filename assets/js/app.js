const $ = (sel, root = document) => (root || document).querySelector(sel);
const $$ = (sel, root = document) => Array.from((root || document).querySelectorAll(sel));

document.addEventListener('DOMContentLoaded', () => {
  // Play button
  const playBtn = $('.play .btn');
  if (playBtn){
    playBtn.addEventListener('click', () => {
      const slot = $('.video-slot');
      const yt = slot?.dataset?.youtube || 'https://www.youtube.com/embed/dQw4w9WgXcQ';
      slot.innerHTML = `<iframe width="100%" height="100%" src="${yt}?autoplay=1&rel=0&modestbranding=1" title="MKProd Reel" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>`;
    });
  }

  // Build segmented controls (complexity & cms)
  function buildSeg(id, hiddenId, defaultVal){
    const seg = $(id);
    if(!seg) return null;
    let hid = $(hiddenId);
    if(!hid){
      hid = document.createElement('input');
      hid.type = 'hidden'; hid.id = hiddenId.replace('#',''); hid.value = String(defaultVal ?? 1);
      seg.parentElement.appendChild(hid);
    }
    seg.addEventListener('click', (e)=>{
      const btn = e.target.closest('.seg-btn'); if(!btn) return;
      seg.querySelectorAll('.seg-btn').forEach(b=>b.classList.remove('active'));
      btn.classList.add('active');
      btn.setAttribute('aria-selected','true');
      seg.querySelectorAll('.seg-btn').forEach(b=>{ if(b!==btn) b.removeAttribute('aria-selected') });
      hid.value = btn.dataset.val;
      document.dispatchEvent(new Event('recompute'));
    });
    return hid;
  }
  const hiddenComplexity = buildSeg('#complexitySeg','#complexity',1);
  const hiddenCms = buildSeg('#cmsSeg','#cms',1);

  // Calculator
  const calc = {};
  function resolveCalcEls(){
    calc.seo = $('#seoRange');
    calc.site = $('#siteRange');
    calc.ads = $('#adsRange');
    calc.complexity = $('#complexity');
    calc.cms = $('#cms');
    calc.total = $('#totalOut');
    calc.breakdown = $('#breakdown');
  }
  resolveCalcEls();

  const formatCurrency = (n) => new Intl.NumberFormat('ru-RU').format(Math.round(n)) + ' ₽';
  function recompute(){
    resolveCalcEls();
    const seo = Number(calc.seo?.value || 0);
    const site = Number(calc.site?.value || 0);
    const ads = Number(calc.ads?.value || 0);
    const complexityK = Number(calc.complexity?.value || 1);
    const cmsK = Number(calc.cms?.value || 1);
    const siteCost = site * complexityK * cmsK;
    const month = seo + ads;
    const total = siteCost + month;
    if (calc.total) calc.total.textContent = formatCurrency(total);
    if (calc.breakdown) calc.breakdown.innerHTML = `
      <div>Разработка: <b>${formatCurrency(siteCost)}</b></div>
      <div>SEO/мес: <b>${formatCurrency(seo)}</b></div>
      <div>Контекст/мес: <b>${formatCurrency(ads)}</b></div>
    `;
  }
  ['seoRange','siteRange','adsRange','complexity','cms'].forEach(id=>{
    const el = document.getElementById(id);
    if (el) ['input','change'].forEach(ev=> el.addEventListener(ev, recompute));
  });
  document.addEventListener('recompute', recompute);
  recompute();

  const calcCta = $('#calcContactBtn');
  if (calcCta){
    calcCta.addEventListener('click', ()=>{
      const target = document.getElementById('contact');
      if (!target) return;
      try {
        target.scrollIntoView({behavior:'smooth', block:'start'});
      } catch (err) {
        target.scrollIntoView(true);
      }
      const focusable = target.querySelector('input, textarea, button, select');
      if (focusable){
        setTimeout(()=>{
          try {
            focusable.focus();
          } catch (e) {
            /* noop */
          }
        }, 600);
      }
    });
  }

  // Generic smooth scroll controls
  $$('[data-scroll-to]').forEach(btn => {
    const selector = btn.getAttribute('data-scroll-to');
    if (!selector) return;
    btn.addEventListener('click', () => {
      const target = document.querySelector(selector);
      if (!target) return;
      try {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      } catch (err) {
        target.scrollIntoView(true);
      }
      const focusable = target.querySelector('input, textarea, button, select');
      if (focusable) {
        setTimeout(() => {
          try { focusable.focus(); } catch (e) { /* ignore */ }
        }, 600);
      }
    });
  });

  // Scroll progress indicator
  const scrollProgressBar = $('.scroll-progress__bar');
  if (scrollProgressBar) {
    const updateProgress = () => {
      const doc = document.documentElement;
      const max = (doc.scrollHeight || 0) - window.innerHeight;
      const ratio = max > 0 ? Math.min(1, Math.max(0, (window.scrollY || window.pageYOffset) / max)) : 0;
      scrollProgressBar.style.width = (ratio * 100).toFixed(2) + '%';
    };
    updateProgress();
    window.addEventListener('scroll', updateProgress, { passive: true });
    window.addEventListener('resize', updateProgress);
  }

  // SEO landing calculator
  const seoCalcRoot = document.querySelector('[data-seo-calc]');
  if (seoCalcRoot) {
    const basePrice = Number(seoCalcRoot.dataset.basePrice || 50000);
    const siteButtons = $$('[data-type="site"]', seoCalcRoot);
    const complexityButtons = $$('[data-type="complexity"]', seoCalcRoot);
    const totalOut = $('[data-total]', seoCalcRoot);
    const breakdownRows = $$('[data-breakdown] .seo-calc__breakdown-row', seoCalcRoot);
    const breakdownDefaults = breakdownRows.map(row => Number(row.dataset.defaultAmount || 0));
    const baseSum = breakdownDefaults.reduce((sum, val) => sum + val, 0) || basePrice;

    let siteMultiplier = Number((siteButtons.find(btn => btn.classList.contains('active')) || siteButtons[0])?.dataset.multiplier || 1);
    let complexityMultiplier = Number((complexityButtons.find(btn => btn.classList.contains('active')) || complexityButtons[0])?.dataset.multiplier || 1);

    const setActive = (buttons, current) => {
      buttons.forEach(btn => {
        if (btn === current) {
          btn.classList.add('active');
          btn.setAttribute('aria-selected', 'true');
        } else {
          btn.classList.remove('active');
          btn.removeAttribute('aria-selected');
        }
      });
    };

    const updateSeoCalc = () => {
      const total = basePrice * siteMultiplier * complexityMultiplier;
      if (totalOut) totalOut.textContent = formatCurrency(total);
      breakdownRows.forEach((row, idx) => {
        const strong = row.querySelector('strong');
        if (!strong) return;
        const base = breakdownDefaults[idx] || 0;
        let value = total;
        if (baseSum > 0 && base > 0) {
          value = total * (base / baseSum);
        } else if (baseSum > 0 && base === 0) {
          value = total * (1 / breakdownRows.length);
        } else if (!baseSum && breakdownRows.length) {
          value = total / breakdownRows.length;
        }
        strong.textContent = formatCurrency(value);
      });
    };

    siteButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        siteMultiplier = Number(btn.dataset.multiplier || 1) || 1;
        setActive(siteButtons, btn);
        updateSeoCalc();
      });
    });
    complexityButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        complexityMultiplier = Number(btn.dataset.multiplier || 1) || 1;
        setActive(complexityButtons, btn);
        updateSeoCalc();
      });
    });

    updateSeoCalc();
  }

  // Global async contact form
  const asyncForm = $('form[data-global-form="1"]');
  if (asyncForm && !asyncForm.dataset.mkpAjax) {
    asyncForm.dataset.mkpAjax = '1';
    const submitBtn = $('#submitBtn', asyncForm) || asyncForm.querySelector('button[type="submit"]');
    const btnText = submitBtn?.querySelector('.btn-text');
    const loader = submitBtn?.querySelector('.loader');
    const msgBox = $('#formMsg', asyncForm);
    const overlay = document.getElementById('successOverlay');
    const overlayClose = document.getElementById('overlayClose');
    const progressWrap = asyncForm.querySelector('.progress-wrap');
    const progressBar = progressWrap?.querySelector('.progress-bar');
    const inputFiles = $('#files', asyncForm);
    const honeypot = $('#website', asyncForm);
    const endpoint = asyncForm.dataset.endpoint || asyncForm.getAttribute('action') || '';

    const allowedExtensions = ['jpg','jpeg','png','webp','gif','pdf','doc','docx','txt','rtf','odt','ppt','pptx','xls','xlsx','csv','zip','rar','7z','gz','tar','mp3','wav','ogg','m4a','aac','mp4','mov','avi','mkv'];
    const allowedExtSet = new Set(allowedExtensions);

    const closeOverlay = () => {
      if (!overlay) return;
      overlay.classList.remove('show');
      overlay.setAttribute('aria-hidden', 'true');
      submitBtn?.focus({ preventScroll: true });
    };
    const showOverlay = () => {
      if (!overlay) return;
      overlay.classList.add('show');
      overlay.setAttribute('aria-hidden', 'false');
      overlayClose?.focus({ preventScroll: true });
    };
    overlayClose?.addEventListener('click', closeOverlay);
    overlay?.addEventListener('click', (e) => { if (e.target === overlay) closeOverlay(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && overlay?.classList.contains('show')) closeOverlay(); });

    const getSelectedFiles = () => {
      if (typeof window.mkpGetFiles === 'function') {
        const buffer = window.mkpGetFiles();
        return Array.isArray(buffer) ? buffer.slice() : [];
      }
      if (!inputFiles?.files) return [];
      return Array.from(inputFiles.files);
    };

    const setLoading = (loading) => {
      if (!submitBtn) return;
      submitBtn.disabled = loading;
      if (btnText) btnText.style.display = loading ? 'none' : 'inline';
      if (loader) loader.style.display = loading ? 'inline-block' : 'none';
      if (progressWrap) {
        progressWrap.hidden = !loading;
        if (!loading && progressBar) {
          setTimeout(() => { progressBar.style.width = '0%'; }, 600);
        }
      }
    };

    asyncForm.addEventListener('submit', (e) => {
      e.preventDefault();
      if (msgBox) {
        msgBox.textContent = '';
        msgBox.className = 'form-msg';
      }
      if (honeypot && honeypot.value.trim() !== '') return;
      const files = getSelectedFiles();
      for (const file of files) {
        if (file.size > 20 * 1024 * 1024) {
          if (msgBox) {
            msgBox.textContent = `❌ Файл ${file.name} превышает 20 МБ`;
            msgBox.classList.add('error');
          }
          return;
        }
        const parts = file.name.split('.');
        const ext = parts.length > 1 ? parts.pop().toLowerCase() : '';
        if (ext && !allowedExtSet.has(ext)) {
          if (msgBox) {
            msgBox.textContent = `❌ Файл ${file.name} имеет неподдерживаемый формат`;
            msgBox.classList.add('error');
          }
          return;
        }
      }

      if (!endpoint) {
        if (msgBox) {
          msgBox.textContent = '❌ Ошибка: не указан адрес отправки.';
          msgBox.classList.add('error');
        }
        return;
      }

      setLoading(true);
      if (progressBar) progressBar.style.width = '0%';

      const data = new FormData(asyncForm);
      if (typeof window.mkpGetFiles === 'function') {
        const buffered = getSelectedFiles();
        data.delete('files[]');
        buffered.forEach(file => data.append('files[]', file, file.name));
      }

      const xhr = new XMLHttpRequest();
      xhr.open('POST', endpoint, true);
      xhr.upload.onprogress = (event) => {
        if (!progressBar || !event.lengthComputable) return;
        const percent = (event.loaded / event.total) * 100;
        progressBar.style.width = percent.toFixed(1) + '%';
      };
      xhr.onerror = () => {
        setLoading(false);
        if (msgBox) {
          msgBox.textContent = '❌ Ошибка сети.';
          msgBox.classList.add('error');
        }
      };
      xhr.onload = () => {
        setLoading(false);
        if (progressWrap) progressWrap.hidden = true;
        try {
          const json = JSON.parse(xhr.responseText || '{}');
          if (json.ok) {
            asyncForm.reset();
            if (typeof window.mkpClearFiles === 'function') window.mkpClearFiles();
            if (msgBox) {
              msgBox.textContent = '';
              msgBox.className = 'form-msg';
            }
            showOverlay();
          } else {
            if (msgBox) {
              msgBox.textContent = '❌ Ошибка: ' + (json.msg || 'не удалось отправить.');
              msgBox.classList.add('error');
            }
          }
        } catch (err) {
          if (msgBox) {
            msgBox.textContent = '❌ Ошибка отправки.';
            msgBox.classList.add('error');
          }
        }
      };
      xhr.send(data);
    });
  }

  // Card glow
  $$('.card').forEach(card=>{
    card.addEventListener('mousemove', (e)=>{
      const r = card.getBoundingClientRect();
      const x = (e.clientX - r.left) / r.width * 100;
      card.style.setProperty('--x', x + '%');
    });
  });

  // Parallax
  const parallaxEls = [...$$('.hero [data-parallax-speed]')];
  let lastY = 0, ticking = false;
  function onScroll(){
    lastY = window.scrollY || window.pageYOffset;
    if (!ticking){
      window.requestAnimationFrame(()=>{
        parallaxEls.forEach(el=>{
          const speed = parseFloat(el.dataset.parallaxSpeed || '0.1');
          el.style.transform = `translateY(${lastY * speed * -1}px)`;
        });
        ticking = false;
      });
      ticking = true;
    }
  }
  window.addEventListener('scroll', onScroll, {passive:true});
  onScroll();
});


// Scroll reveal
const revealEls = [...$$('[data-reveal], .card, .step, .price, .quote, .badges .badge')];
const io = new IntersectionObserver((entries)=>{
  entries.forEach(ent=>{
    if (ent.isIntersecting){
      ent.target.classList.add('reveal-on-scroll');
      io.unobserve(ent.target);
    }
  });
}, {threshold: 0.15});
revealEls.forEach(el=> io.observe(el));


// MKP_CONTACTS_PARALLAX
document.addEventListener('DOMContentLoaded', function(){
  var card = document.querySelector('.mkp-contacts');
  var grid = document.querySelector('.mkp-contacts .mkp-contacts-grid');
  if(!card || !grid) return;
  card.addEventListener('mousemove', function(e){
    var r = card.getBoundingClientRect();
    var x = (e.clientX - r.left)/r.width - 0.5;
    var y = (e.clientY - r.top)/r.height - 0.5;
    grid.style.transform = 'translate(' + (-x*12) + 'px,' + (-y*12) + 'px)';
  });
  card.addEventListener('mouseleave', function(){ grid.style.transform='translate(0,0)'; });
});


// MKP_TICKER_DUO_VIS
document.addEventListener('visibilitychange', function(){
  var left = document.querySelector('.mkp-ticker .dir-left');
  var right = document.querySelector('.mkp-ticker .dir-right');
  if(!left || !right) return;
  var state = document.hidden ? 'paused' : 'running';
  left.style.animationPlayState = state;
  right.style.animationPlayState = state;
});


// ----- FIX: двойное открытие + продвинутый дропзон (обновлённый) -----
document.addEventListener('DOMContentLoaded', function(){
  const dropzone   = document.getElementById('dropzone');
  const inputFiles = document.getElementById('files');
  const dzBtn      = dropzone ? dropzone.querySelector('.dz-btn') : null;
  const dzList     = document.getElementById('dzList');
  if(!dropzone || !inputFiles || !dzBtn || !dzList) return;

  let pickerBusy = false;
  let filesBuffer = [];
  let dragCounter = 0;

  function syncNativeInput(){
    if (typeof DataTransfer !== 'function') return;
    const dt = new DataTransfer();
    filesBuffer.forEach(file => dt.items.add(file));
    inputFiles.files = dt.files;
  }

  function renderList(){
    dzList.innerHTML = '';
    filesBuffer.forEach((f,i)=>{
      const li = document.createElement('li');
      li.className = 'dz-item';        // новый класс
      // название файла в отдельном спане — чтобы крестик не наезжал
      const name = document.createElement('span');
      name.className = 'dz-name';
      name.textContent = f.name;

      const del = document.createElement('button');
      del.type = 'button';
      del.className = 'dz-del';
      del.setAttribute('aria-label','Удалить файл ' + f.name);
      del.textContent = '✕';
      del.onclick = ()=>{
        filesBuffer.splice(i,1);
        renderList();
      };

      li.appendChild(name);
      li.appendChild(del);
      dzList.appendChild(li);

      // триггерим анимацию появления
      requestAnimationFrame(()=> li.classList.add('enter'));
    });
    syncNativeInput();
  }

  function addFiles(fileList){
    if (!fileList || !fileList.length) return;
    Array.from(fileList).forEach(file => {
      const duplicate = filesBuffer.some(x => x.name === file.name && x.size === file.size && x.lastModified === file.lastModified);
      if (!duplicate) filesBuffer.push(file);
    });
    renderList();
  }

  function openPickerOnce(){
    if (pickerBusy) return;
    pickerBusy = true;
    inputFiles.value = '';
    inputFiles.click();
    setTimeout(()=>{ pickerBusy = false; }, 350);
  }

  dzBtn.addEventListener('click', e=>{
    e.preventDefault(); e.stopPropagation(); e.stopImmediatePropagation();
    openPickerOnce();
  }, true);

  dropzone.addEventListener('click', e=>{
    if (e.target.closest('.dz-btn') || e.target.closest('#dzList')) return;
    if (e.currentTarget === e.target || e.target.closest('.dz-cta')) openPickerOnce();
  });

  inputFiles.addEventListener('change', ()=>{
    addFiles(inputFiles.files);
  });

  dropzone.addEventListener('dragenter', e=>{
    e.preventDefault();
    dragCounter++;
    dropzone.classList.add('is-dragover');
  });

  dropzone.addEventListener('dragover', e=>{
    e.preventDefault();
  });

  dropzone.addEventListener('dragleave', e=>{
    if (e.relatedTarget && dropzone.contains(e.relatedTarget)) {
      dragCounter = Math.max(0, dragCounter - 1);
      return;
    }
    dragCounter = 0;
    dropzone.classList.remove('is-dragover');
  });

  dropzone.addEventListener('drop', e=>{
    e.preventDefault();
    dragCounter = 0;
    dropzone.classList.remove('is-dragover');
    const files = e.dataTransfer?.files;
    if (files && files.length){
      addFiles(files);
    }
  });

  // Инжектим стили для нового макета + неоновой анимации
  const style = document.createElement('style');
  style.textContent = `
    .mkp-dropzone.is-dragover{
      border-style:solid;
      border-color:rgba(0,240,255,.6);
      background:rgba(0,240,255,.08);
      box-shadow:0 0 18px rgba(0,240,255,.25),0 0 32px rgba(122,92,255,.18);
    }

    /* Список: flex-«чипсы» с разносом имени и крестика */
    .dz-list{
      list-style:none;margin:10px 0 0;padding:0;
      display:flex;flex-wrap:wrap;gap:8px;
    }
    .dz-item{
      display:inline-flex;align-items:center;gap:12px;
      padding:6px 8px 6px 12px;
      border:1px solid rgba(0,240,255,.25);
      border-radius:999px;
      background:rgba(0,240,255,.04);
      box-shadow: inset 0 0 0 rgba(0,240,255,0);
      /* стартовое состояние для анимации */
      opacity:0; transform: translateY(6px);
    }
    .dz-item.enter{
      animation: dz-in .35s ease forwards;
    }
    .dz-name{
      max-width: 260px;
      white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
      font-size:13px;color:var(--muted);
    }
    .dz-del{
      position:static; /* важное отличие: больше не absolute */
      width:22px;height:22px;line-height:20px;
      display:inline-grid;place-items:center;
      border:1px solid rgba(0,240,255,.35);
      border-radius:50%;
      background:rgba(0,240,255,.06);
      color:rgba(0,240,255,.85);
      cursor:pointer;
      font-size:13px;font-weight:700;
      transition:transform .2s ease, box-shadow .2s ease, color .2s ease, border-color .2s ease;
      box-shadow: 0 0 0 rgba(0,240,255,0);
    }
    .dz-del:hover{
      transform: scale(1.12);
      color:#fff; border-color:#7a5cff;
      box-shadow: 0 0 10px rgba(0,240,255,.35), 0 0 14px rgba(122,92,255,.25);
    }
    .dz-del:focus-visible{
      outline:2px solid #7a5cff; outline-offset:2px;
    }

    /* неоновая анимация появления элемента */
    @keyframes dz-in{
      0%   { opacity:0; transform:translateY(6px); box-shadow: inset 0 0 0 rgba(0,240,255,0); }
      60%  { opacity:1; transform:translateY(0);   box-shadow: inset 0 0 0 rgba(0,240,255,0.0); }
      100% { opacity:1; transform:translateY(0);   box-shadow: 0 0 12px rgba(0,240,255,.20), 0 0 18px rgba(122,92,255,.12); }
    }

    @media (max-width:640px){
      .dz-name{ max-width: 52vw; }
    }
  `;
  document.head.appendChild(style);

  dropzone.dataset.mkpEnhanced = '1';
  inputFiles.dataset.mkpEnhanced = '1';

  // экспорт, если нужно из другого кода
  window.mkpGetFiles = ()=> filesBuffer;
  window.mkpClearFiles = ()=> { filesBuffer = []; renderList(); };
});
