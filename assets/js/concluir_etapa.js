document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    const stepId = params.get('step_id');
    
    if (stepId) {
        // Create floating button
        const btn = document.createElement('button');
        btn.innerHTML = '✅ Concluir Etapa e Voltar';
        btn.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #f97316;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 15px 20px;
            font-size: 16px;
            font-weight: bold;
            font-family: 'Berkshire Swash', cursive, sans-serif;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
            cursor: pointer;
            z-index: 9999;
            transition: transform 0.2s, background 0.2s;
        `;
        
        btn.onmouseover = () => btn.style.transform = 'scale(1.05)';
        btn.onmouseout = () => btn.style.transform = 'scale(1)';
        
        btn.onclick = async () => {
            btn.innerHTML = '⏳ Salvando...';
            btn.disabled = true;
            btn.style.backgroundColor = '#999';
            
            try {
                const res = await fetch('../auth/update-step.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ step_id: parseInt(stepId) })
                });
                
                if (res.ok) {
                    window.location.href = '../pages/roadmap.php';
                } else {
                    const data = await res.json();
                    alert('Erro ao salvar progresso: ' + (data.erro || 'Falha no servidor'));
                    btn.innerHTML = '❌ Tentar Novamente';
                    btn.disabled = false;
                    btn.style.backgroundColor = '#f97316';
                }
            } catch (err) {
                alert('Erro de conexão.');
                btn.innerHTML = '❌ Tentar Novamente';
                btn.disabled = false;
                btn.style.backgroundColor = '#f97316';
            }
        };
        
        document.body.appendChild(btn);
    }
});
