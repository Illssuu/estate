<div class="mortgage-calculator-wrapper">
    <div class="mortgage-calculator" id="mortgage-calculator-{{ $calculatorId ?? 'default' }}">
    <div class="calculator-header">
        <h3>Ипотечный калькулятор</h3>
        <p>Рассчитайте ежемесячный платёж</p>
    </div>

    <div class="calculator-body">
        {{-- стоимость квартиры --}}
        <div class="calc-row">
            <label for="price-{{ $calculatorId ?? 'default' }}">Стоимость квартиры</label>
            <div class="range-wrapper">
                <input type="range" class="calc-range"
                       id="price-{{ $calculatorId ?? 'default' }}"
                       min="{{ $minPrice ?? 1000000 }}"
                       max="{{ $maxPrice ?? 30000000 }}"
                       step="100000"
                       value="{{ $initialPrice ?? 5000000 }}">
                <div class="range-value">
                    <span id="price-value-{{ $calculatorId ?? 'default' }}">5 000 000</span> ₽
                </div>
            </div>
        </div>

        {{-- перв взнос --}}
        <div class="calc-row">
            <label for="down-payment-{{ $calculatorId ?? 'default' }}">Первоначальный взнос</label>
            <div class="range-wrapper">
                <input type="range" class="calc-range"
                       id="down-payment-{{ $calculatorId ?? 'default' }}"
                       min="10"
                       max="50"
                       value="20">
                <div class="range-value">
                    <span id="down-payment-value-{{ $calculatorId ?? 'default' }}">20</span>%
                    (<span id="down-amount-{{ $calculatorId ?? 'default' }}">1 000 000</span> ₽)
                </div>
            </div>
        </div>

        {{-- срок кредита --}}
        <div class="calc-row">
            <label for="years-{{ $calculatorId ?? 'default' }}">Срок кредита</label>
            <div class="range-wrapper">
                <input type="range" class="calc-range"
                       id="years-{{ $calculatorId ?? 'default' }}"
                       min="5"
                       max="30"
                       value="15">
                <div class="range-value">
                    <span id="years-value-{{ $calculatorId ?? 'default' }}">15</span> лет
                </div>
            </div>
        </div>

        {{-- процентная ставка --}}
        <div class="calc-row">
            <label for="rate-{{ $calculatorId ?? 'default' }}">Процентная ставка</label>
            <div class="range-wrapper">
                <input type="range" class="calc-range"
                       id="rate-{{ $calculatorId ?? 'default' }}"
                       min="5"
                       max="15"
                       step="0.1"
                       value="8.5">
                <div class="range-value">
                    <span id="rate-value-{{ $calculatorId ?? 'default' }}">8.5</span>%
                </div>
            </div>
        </div>

        {{-- результат --}}
        <div class="calc-result">
            <div class="result-label">Ежемесячный платёж</div>
            <div class="result-amount" id="payment-{{ $calculatorId ?? 'default' }}">45 678</div>
            <div class="result-details">
                <span id="loan-amount-{{ $calculatorId ?? 'default' }}">4 000 000</span> ₽ кредит · 
                <span id="total-interest-{{ $calculatorId ?? 'default' }}">2 500 000</span> ₽ переплата
            </div>
        </div>
    </div>
</div>
</div>
<script>
function initMortgageCalculator(calculatorId = 'default') {
    const priceInput = document.getElementById(`price-${calculatorId}`);
    const downInput = document.getElementById(`down-payment-${calculatorId}`);
    const yearsInput = document.getElementById(`years-${calculatorId}`);
    const rateInput = document.getElementById(`rate-${calculatorId}`);
    
    if (!priceInput) return; 
    
    function formatNumber(num) {
        return Math.round(num).toLocaleString('ru-RU');
    }

    function updateRangeColor(rangeInput) {
    const min = rangeInput.min;
    const max = rangeInput.max;
    const val = rangeInput.value;
    const percent = ((val - min) / (max - min)) * 100;
    rangeInput.style.background = `linear-gradient(to right, var(--accent-yellow) 0%, var(--accent-yellow) ${percent}%, #e0e0e0 ${percent}%, #e0e0e0 100%)`;
}
    
    function calculate() {
        const price = parseFloat(priceInput.value);
        const downPercent = parseFloat(downInput.value);
        const years = parseFloat(yearsInput.value);
        const rate = parseFloat(rateInput.value);
        
        const downAmount = price * (downPercent / 100);
        const loanAmount = price - downAmount;
        const months = years * 12;
        const monthlyRate = rate / 100 / 12;
        
        let monthlyPayment = 0;
        if (monthlyRate > 0) {
            monthlyPayment = loanAmount * monthlyRate * Math.pow(1 + monthlyRate, months) / 
                            (Math.pow(1 + monthlyRate, months) - 1);
        } else {
            monthlyPayment = loanAmount / months;
        }
        
        const totalPayment = monthlyPayment * months;
        const totalInterest = totalPayment - loanAmount;
        
        document.getElementById(`price-value-${calculatorId}`).textContent = formatNumber(price);
        document.getElementById(`down-payment-value-${calculatorId}`).textContent = downPercent;
        document.getElementById(`down-amount-${calculatorId}`).textContent = formatNumber(downAmount);
        document.getElementById(`years-value-${calculatorId}`).textContent = years;
        document.getElementById(`rate-value-${calculatorId}`).textContent = rate;
        document.getElementById(`payment-${calculatorId}`).textContent = formatNumber(monthlyPayment);
        document.getElementById(`loan-amount-${calculatorId}`).textContent = formatNumber(loanAmount);
        document.getElementById(`total-interest-${calculatorId}`).textContent = formatNumber(totalInterest);

        updateRangeColor(priceInput);
        updateRangeColor(downInput);
        updateRangeColor(yearsInput);
        updateRangeColor(rateInput);

    }
    
    [priceInput, downInput, yearsInput, rateInput].forEach(input => {
        input.addEventListener('input', calculate);
    });
    
    calculate();
}

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[id^="mortgage-calculator-"]').forEach(calculator => {
        const id = calculator.id.replace('mortgage-calculator-', '');
        initMortgageCalculator(id);
    });
});

document.querySelectorAll('.calc-range').forEach(input => {
    updateRangeColor(input);
});
</script>

