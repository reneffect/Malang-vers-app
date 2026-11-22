let currentBilling = 'monthly';

        function setBilling(type) {
            currentBilling = type;
            const btnMonthly = document.getElementById('btnMonthly');
            const btnYearly  = document.getElementById('btnYearly');

            if (type === 'monthly') {
                btnMonthly.classList.add('bg-white', 'text-blue-700');
                btnMonthly.classList.remove('text-white', 'hover:bg-white/10');
                btnYearly.classList.remove('bg-white', 'text-blue-700');
                btnYearly.classList.add('text-white', 'hover:bg-white/10');
            } else {
                btnYearly.classList.add('bg-white', 'text-blue-700');
                btnYearly.classList.remove('text-white', 'hover:bg-white/10');
                btnMonthly.classList.remove('bg-white', 'text-blue-700');
                btnMonthly.classList.add('text-white', 'hover:bg-white/10');
            }

            // Update harga
            document.querySelectorAll('.price-value').forEach(el => {
                const monthly = parseInt(el.dataset.monthly);
                const yearly  = parseInt(el.dataset.yearly);
                const price   = type === 'monthly' ? monthly : Math.round(yearly / 12);
                el.textContent = price.toLocaleString('id-ID');
            });

            // Update periode
            document.querySelectorAll('.billing-period').forEach(el => {
                el.textContent = type === 'monthly' ? '/bulan' : '/bulan (tagih tahunan)';
            });

            // Tampilkan info tahunan
            document.querySelectorAll('.yearly-info').forEach(el => {
                el.classList.toggle('hidden', type !== 'yearly');
            });
        }

        function toggleFaq(btn) {
            const answer = btn.nextElementSibling;
            const icon   = btn.querySelector('.faq-icon');
            const isOpen = !answer.classList.contains('hidden');

            // Tutup semua
            document.querySelectorAll('.faq-answer').forEach(a => a.classList.add('hidden'));
            document.querySelectorAll('.faq-icon').forEach(i => i.style.transform = 'rotate(0deg)');

            // Buka yang diklik
            if (!isOpen) {
                answer.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            }
        }

        function selectPlan(name, price) {
            if (price === 0) {
                window.showToast('✅ Anda memilih Paket Gratis!');
            } else {
                window.showToast(`🎉 Anda memilih ${name} - Rp ${price.toLocaleString('id-ID')}/bulan`);
            }
        }