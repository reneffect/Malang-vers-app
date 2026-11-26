function setBilling(type) {
    document.querySelectorAll('[data-billing]').forEach((button) => {
        const isSelected = button.dataset.billing === type;
        button.classList.toggle('bg-white', isSelected);
        button.classList.toggle('text-blue-700', isSelected);
        button.classList.toggle('text-white', !isSelected);
        button.classList.toggle('hover:bg-white/10', !isSelected);
    });

    document.querySelectorAll('.price-value').forEach((element) => {
        const monthly = Number(element.dataset.monthly);
        const yearly = Number(element.dataset.yearly);
        const price = type === 'monthly' ? monthly : Math.round(yearly / 12);

        element.textContent = price.toLocaleString('id-ID');
    });

    document.querySelectorAll('.billing-period').forEach((element) => {
        element.textContent = type === 'monthly' ? '/bulan' : '/bulan (tagih tahunan)';
    });

    document.querySelectorAll('.yearly-info').forEach((element) => {
        element.classList.toggle('hidden', type !== 'yearly');
    });

    document.querySelectorAll('[data-checkout-monthly]').forEach((link) => {
        link.href = type === 'monthly'
            ? link.dataset.checkoutMonthly
            : link.dataset.checkoutYearly;
    });
}

document.querySelectorAll('[data-billing]').forEach((button) => {
    button.addEventListener('click', () => setBilling(button.dataset.billing));
});

document.querySelectorAll('.faq-question').forEach((button) => {
    button.addEventListener('click', () => {
        const answer = button.nextElementSibling;
        const icon = button.querySelector('.faq-icon');
        const isOpen = !answer.classList.contains('hidden');

        document.querySelectorAll('.faq-answer').forEach((item) => item.classList.add('hidden'));
        document.querySelectorAll('.faq-icon').forEach((item) => {
            item.style.transform = 'rotate(0deg)';
        });

        if (!isOpen) {
            answer.classList.remove('hidden');
            icon.style.transform = 'rotate(180deg)';
        }
    });
});