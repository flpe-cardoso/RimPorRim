const API_BASE = '../auth';

/* ────────────────────────────────────────────────────────────────────────── */
const CARD_W = 130;
const CARD_GAP = 60;
const SLOT = CARD_W + CARD_GAP;
const PAD = 60;
const Y_TOP = 40;
const Y_BOTTOM = 200;
const TRAIL_H = Y_BOTTOM + CARD_W + 50;

/* ────────────────────────────────────────────────────────────────────────── */
let steps = [];
let progress = 0;

/* ────────────────────────────────────────────────────────────────────────── */
const elLoading = document.getElementById('trail-loading');
const elInner = document.getElementById('trail-inner');
const elScroll = document.getElementById('trail-scroll');
const elProgressFil = document.getElementById('progress-fill');
const elProgressPct = document.getElementById('progress-pct');
const elFlameCount = document.getElementById('flame-count');
const elHint = document.getElementById('trail-hint');

/* ────────────────────────────────────────────────────────────────────────── */
function buildZigZagPath(count) {
  if (count < 2) return '';

  const half = CARD_W / 2;

  const pts = Array.from({ length: count }, (_, i) => ({
    x: PAD + half + i * SLOT,
    y: (i % 2 === 0 ? Y_TOP : Y_BOTTOM) + half,
  }));

  let d = `M ${pts[0].x} ${pts[0].y}`;

  for (let i = 1; i < pts.length; i++) {
    const p = pts[i - 1];
    const q = pts[i];
    const cx = (p.x + q.x) / 2;

    d += ` C ${cx} ${p.y} ${cx} ${q.y} ${q.x} ${q.y}`;
  }

  return d;
}

/* ────────────────────────────────────────────────────────────────────────── */
function recalcProgress() {
  const concluidos = steps.filter(s => s.concluido).length;
  progress = steps.length ? Math.round((concluidos / steps.length) * 100) : 0;

  if (elProgressFil) elProgressFil.style.width = `${progress}%`;
  if (elProgressPct) elProgressPct.textContent = `${progress}%`;
  if (elFlameCount)  elFlameCount.textContent = progress;
}

/* ────────────────────────────────────────────────────────────────────────── */
function isStepLocked(index) {
  if (index === 0) return false;
  return !steps[index - 1].concluido;
}

/* ────────────────────────────────────────────────────────────────────────── */
function toggleStep(id, index, silent = false) {
  const step = steps[index];
  if (!step) return;

  if (isStepLocked(index)) return;
  if (step.concluido) return;

  step.concluido = true;

  const card = elInner?.querySelector(`.step-card[data-id="${id}"]`);
  if (card) {
    card.dataset.done = 'true';

    if (!card.querySelector('.step-card__check')) {
      card.prepend(criarCheckBadge());
    }
  }

  recalcProgress();

  recalcProgress();
}

/* ────────────────────────────────────────────────────────────────────────── */
function criarCheckBadge() {
  const div = document.createElement('div');
  div.className = 'step-card__check';

  div.innerHTML = `
    <svg width="12" height="12" viewBox="0 0 24 24"
         fill="none" stroke="white" stroke-width="3.5" stroke-linecap="round">
      <polyline points="20 6 9 17 4 12"/>
    </svg>`;

  return div;
}

/* ────────────────────────────────────────────────────────────────────────── */
function criarCard(step, index) {
  const card = document.createElement('a');
  card.href = step.url || '#';
  card.className = 'step-card';
  card.dataset.id = step.id;
  card.dataset.done = String(step.concluido);
  card.style.marginTop = `${index % 2 === 0 ? Y_TOP : Y_BOTTOM}px`;

  if (isStepLocked(index)) {
    card.classList.add('locked');
  }

  if (step.concluido) {
    card.appendChild(criarCheckBadge());
  }

  const num = document.createElement('div');
  num.className = 'step-card__number';
  num.textContent = `#${index + 1}`;
  card.appendChild(num);

  const icone = document.createElement('span');
  icone.className = 'step-card__icon';
  icone.textContent = step.icone;
  card.appendChild(icone);

  const titulo = document.createElement('span');
  titulo.className = 'step-card__title';
  titulo.textContent = step.titulo;
  card.appendChild(titulo);

  card.addEventListener('click', (e) => {
    if (isStepLocked(index)) {
      e.preventDefault();
      return;
    }

    if (!step.concluido) {
      e.preventDefault();
      const sep = step.url.includes('?') ? '&' : '?';
      window.location.href = step.url + sep + 'step_id=' + step.id;
    }
  });

  return card;
}

/* ────────────────────────────────────────────────────────────────────────── */
function renderTrilha() {
  if (!elInner) return;

  elInner.innerHTML = '';

  const totalW = PAD * 2 + steps.length * SLOT;
  const pathD = buildZigZagPath(steps.length);

  elInner.style.width = `${totalW}px`;
  elInner.style.height = `${TRAIL_H}px`;
  elInner.style.paddingLeft = `${PAD}px`;
  elInner.style.paddingRight = `${PAD}px`;
  elInner.style.gap = `${CARD_GAP}px`;

  const svgNS = 'http://www.w3.org/2000/svg';
  const svg = document.createElementNS(svgNS, 'svg');
  svg.setAttribute('class', 'trail-path-svg');
  svg.setAttribute('viewBox', `0 0 ${totalW} ${TRAIL_H}`);
  svg.style.width = `${totalW}px`;
  svg.style.height = `${TRAIL_H}px`;

  const halo = document.createElementNS(svgNS, 'path');
  halo.setAttribute('d', pathD);
  halo.setAttribute('fill', 'none');
  halo.setAttribute('stroke', '#f5f3ee');
  halo.setAttribute('stroke-width', '10');

  const trace = document.createElementNS(svgNS, 'path');
  trace.setAttribute('d', pathD);
  trace.setAttribute('fill', 'none');
  trace.setAttribute('stroke', '#fdba74');
  trace.setAttribute('stroke-width', '4');
  trace.setAttribute('stroke-dasharray', '12 7');

  svg.appendChild(halo);
  svg.appendChild(trace);
  elInner.appendChild(svg);

  steps.forEach((step, i) => {
    elInner.appendChild(criarCard(step, i));
  });

  recalcProgress();

  if (elLoading) elLoading.style.display = 'none';
  if (elHint) elHint.style.display = 'block';
}

/* ────────────────────────────────────────────────────────────────────────── */
async function carregarEtapas() {
  try {
    const res = await fetch(`${API_BASE}/get-steps.php`, {
      credentials: 'include'
    });

    if (!res.ok) {
      console.error('Erro HTTP:', res.status);
      return;
    }

    const text = await res.text();

    let data;
    try {
      data = JSON.parse(text);
    } catch (e) {
      console.error('JSON inválido vindo do PHP:', text);
      return;
    }

    if (!data.steps) {
      console.error('Resposta sem "steps":', data);
      return;
    }

    steps = data.steps;

    renderTrilha();

  } catch (e) {
    console.error('[Trilha] Erro ao carregar etapas:', e);
  }
}

/* ────────────────────────────────────────────────────────────────────────── */
const btnVoltar = document.getElementById('btn-voltar');
if (btnVoltar) {
  btnVoltar.addEventListener('click', () => {
    window.history.back();
  });
}

/* ────────────────────────────────────────────────────────────────────────── */
if (elScroll) {

  let arrastando = false;
  let startX = 0;
  let scrollLeft = 0;

  elScroll.addEventListener('mousedown', (e) => {
    arrastando = true;
    startX = e.pageX - elScroll.offsetLeft;
    scrollLeft = elScroll.scrollLeft;
    elScroll.style.cursor = 'grabbing';
  });

  elScroll.addEventListener('mouseleave', () => {
    arrastando = false;
    elScroll.style.cursor = 'grab';
  });

  elScroll.addEventListener('mouseup', () => {
    arrastando = false;
    elScroll.style.cursor = 'grab';
  });

  elScroll.addEventListener('mousemove', (e) => {
    if (!arrastando) return;
    e.preventDefault();

    const x = e.pageX - elScroll.offsetLeft;
    const walk = (x - startX) * 1.5;
    elScroll.scrollLeft = scrollLeft - walk;
  });

  let touchStartX = 0;
  let touchScroll = 0;

  elScroll.addEventListener('touchstart', (e) => {
    touchStartX = e.touches[0].pageX;
    touchScroll = elScroll.scrollLeft;
  }, { passive: true });

  elScroll.addEventListener('touchmove', (e) => {
    const move = touchStartX - e.touches[0].pageX;
    elScroll.scrollLeft = touchScroll + move * 1.2;
  }, { passive: true });

  elScroll.addEventListener('wheel', (e) => {
    e.preventDefault();
    elScroll.scrollLeft += e.deltaY * 1.5;
  }, { passive: false });
}

carregarEtapas();