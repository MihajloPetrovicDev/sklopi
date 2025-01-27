const numberFormatService = {
    formatNumberToComaDecimalSeparator(number) {
        const fixedDecimalPlacesNumber = number.toFixed(2);
        let [integerPart, decimalPart] = fixedDecimalPlacesNumber.split('.');
        
        integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        const formatedNumber = integerPart + ',' + decimalPart;

        return formatedNumber;
    } 
}


export default numberFormatService;