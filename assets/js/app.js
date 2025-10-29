const $ = (sel, root=document) => root.querySelector(sel);
const $$ = (sel, root=document) => root.querySelectorAll(sel);

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

  const fmt = (n) => new Intl.NumberFormat('ru-RU').format(Math.round(n)) + ' ₽';
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
    if (calc.total) calc.total.textContent = fmt(total);
    if (calc.breakdown) calc.breakdown.innerHTML = `
      <div>Разработка: <b>${fmt(siteCost)}</b></div>
      <div>SEO/мес: <b>${fmt(seo)}</b></div>
      <div>Контекст/мес: <b>${fmt(ads)}</b></div>
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
const revealEls = [...$$('.card, .step, .price, .quote, .badges .badge')];
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
      del.onclick = ()=>{ filesBuffer.splice(i,1); renderList(); };

      li.appendChild(name);
      li.appendChild(del);
      dzList.appendChild(li);

      // триггерим анимацию появления
      requestAnimationFrame(()=> li.classList.add('enter'));
    });
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
    for(const f of inputFiles.files){
      if(!filesBuffer.some(x=>x.name===f.name && x.size===f.size)) filesBuffer.push(f);
    }
    renderList();
  });

  // Инжектим стили для нового макета + неоновой анимации
  const style = document.createElement('style');
  style.textContent = `
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

  // экспорт, если нужно из другого кода
  window.mkpGetFiles = ()=> filesBuffer;
});