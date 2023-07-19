
// Currency format for numbers
const currencyFormat = function(number){
    let format = new Intl.NumberFormat('en-Ca', { style: 'currency', currency: 'CAD' }).format(number);
    return format
}


// Calculation

let bill = Number(cost.value);                  // Default cost of the meal ($0.00)
let gst = Number(province.value);               // Default province GST (Alberta 5%)
let tipPercentage = percentage.valueAsNumber;   // Default tip percentage
let tip = bill * tipPercentage;                 // Initial tip ($0.00)
let subtotal = 0;                               // Initial Subtotal
let taxes = bill * gst;                     // Initial taxes fee
let diners = noDiners.valueAsNumber;            // Default number of diners (1)
let total = 0;                                  // Initial total



const calculate = function(){                   // Function to calculate all the fees
    
    let tipSimplified = tipPercentage/100;      // Calculating tip
    tip = bill * tipSimplified;                
    
    let gstSimplified = gst/100;                 //Taxes
    taxes = bill * gstSimplified;

    subtotal = bill + tip;                      //Pre-tax total
    
    total = subtotal + taxes;                   // Grand total
    split = total / diners;                     // Split total 
    

    // To currency
    let billF = currencyFormat(bill.toFixed(2));
    let tipF = currencyFormat(tip.toFixed(2));
    let taxesF = currencyFormat(taxes.toFixed(2));
    let subtotalF = currencyFormat(subtotal.toFixed(2));
    let totalF = currencyFormat(total.toFixed(2));
    let splitF = currencyFormat(split.toFixed(2));


    // Printing values
    billDisplay.innerHTML = billF;
    tipDisplay.innerHTML = tipF;
    taxesDisplay.innerHTML = taxesF;
    subtotalDisplay.innerHTML = subtotalF;
    totalDisplay.innerHTML = totalF;
    dinersDisplay.innerHTML = diners;
    splitDisplay.innerHTML = splitF;
    
}

calculate(); // Getting initial values


// Display boxes
const display = document.querySelector('.display'); // Display box


// Hiding elements
const hide = function(element){
    element.classList.add('hidden');
}
const unhide = function(element){
    element.classList.remove('hidden');
}
const toggle = function(element){
    element.classList.toggle('hidden');
}

const hideClass = function(classToHide){
    let allElements = document.querySelectorAll(`.${classToHide}`);
    allElements.forEach(element=>{
        hide(element)
    }) 
}



// Keyboard ----------------

//  To create keyboards keys
const newKey = function(content){
    let newButton = document.createElement("button");
    newButton.classList.add('key');
    newButton.setAttribute('type','button')
    newButton.innerHTML = content;
    return newButton;
}

// Creating keyboard keys from 0 to 9
let keyboard = document.querySelector('.keyboard');                 // Keyboard container
for(let i = 9; i >= 0 ;i--){

    let newButton = newKey(i);
    newButton.setAttribute('value', i);
    keyboard.appendChild(newButton);
    

    newButton.addEventListener('click', function(e){
        e.preventDefault();
        let keyValue = this.value;

        let checkValue = cost.value;
        
        if(checkValue.includes('.') && checkValue.split('.')[1].length >=2){            // Decimal conditions. It doesn't allow more than two decimals.
            console.log('No more than two decimals allowed.')
            return;
        }else{
            if(checkValue.includes('0') && checkValue.indexOf('0')===0 && !checkValue.includes('0.')){      // It doesn't allow left zeros unless they have a point after
                cost.value = checkValue.slice(0,0)
            }
            cost.value += keyValue;                 // Inserting key values to the input string
            cost.dispatchEvent(new Event('input'));
        }
    })
}

// Pont key
let point = newKey('.');                                            // Point key 
point.setAttribute('value', '.');
point.addEventListener('click', function(e){        // Pressing point key
    e.preventDefault();
    let current = cost.value;
    if(!current.includes('.')){
        cost.value = current + ".";
        cost.dispatchEvent(new Event('input'));     // Generating an input event
    }
})

//Delete key
let deleteKey = newKey('<img alt="Delete" src="graphics/icon-delete.svg">');     // Delete key
deleteKey.addEventListener('click', function(e){    // Pressing delete key
    e.preventDefault();
    let current = cost.value;
    cost.value = current.slice(0,-1)                // Deleting the last input
    cost.dispatchEvent(new Event('input'));
})


keyboard.appendChild(point);                
keyboard.appendChild(deleteKey);


// Informative buttons

// It creates a new paragraph  for additional information pop up windows and hides it.
const infoMessage = function(container,message){
    let newP = document.createElement("p");
    newP.classList.add('info-message', 'hidden')
    newP.innerHTML = message;
    container.appendChild(newP);
    return newP
}

let infoButtons = document.querySelectorAll('.info-button');       // Informative buttons containers
let cont = 0;   

infoButtons.forEach(infoButton =>{

    infoButton.innerHTML = '<img alt="More info" src="graphics/info-icon.svg">';   // Icon
    let message = '';
    if(cont == 0){
        message = 'Bon appetite! Please, insert the total in your bill (up to 6 digits).';
    }else if(cont == 1){
        message = 'Tell us how many companions you brought today.';
    }else if(cont == 2){
        message = 'Select your tip in 5% intervals up to 30%. Be generous with your waiter.';
    }else if(cont == 3){
        message = 'Select the province where you are eating to calculate taxes.';
    }
    
    let infoP = infoMessage(infoButton,message);
    infoButton.addEventListener('click',function(e){
        e.preventDefault();
        toggle(infoP);
    })
    cont++
})


// Increase and decrease  buttons for number of diners

addOne.addEventListener('click', function(e){
    e.preventDefault();
    noDiners.valueAsNumber++;
    noDiners.dispatchEvent(new Event('input'));
})
subtractOne.addEventListener('click', function(e){
    e.preventDefault();
    if(noDiners.value>1){    // Number of diners must be equal or greater than one
        noDiners.valueAsNumber--;
        noDiners.dispatchEvent(new Event('input'));
    }else{
        console.log('Come on! There must be more than 1 diner.');
    }
})




// Bill
cost.addEventListener('input', function (e) {
    e.preventDefault();
    checkBill = Number(this.value);
    if(!Number.isNaN(checkBill) && this.value.length <= 8){   // not allowing input invalid characters and setting a max number of characters allowed
        if(checkBill == 0 && !checkBill === '0.'){
            this.value = 0;
        }
        bill = checkBill;
        console.log(`The total cost of the meal has been changed to: ${bill}`);
        calculate();
    }else{
        this.value = bill;
        console.log('Invalid character or maximum number of characters reached');
    }
})

// Tip

const percentageDisplay = document.querySelector('.label+div .display'); // For displaying the percentage
percentage.addEventListener('input',function(e){
    e.preventDefault();
    
    tipPercentage = percentage.valueAsNumber;
    console.log(`The tip percentage has been changed to: ${tipPercentage}%`)
    percentageDisplay.innerHTML=`${tipPercentage}%`;
    calculate();
    
})

// Taxes

province.addEventListener('change', function(e){
    e.preventDefault();
    let chosenProvince
    gst = Number(province.value);
    console.log(`GST in your chosen province is: ${gst}%`);
    gstDisplay.innerHTML = `${gst}%`;
    calculate()
})

//Diners

noDiners.addEventListener('input',function(e){
    e.preventDefault();
    let checkDiners = this.valueAsNumber
    if(Number.isInteger(checkDiners) && checkDiners > 0){
        diners = checkDiners;
        console.log(`The number diners has changed to: ${diners}`);
        calculate();
    }else{
        this.value = diners;
    }
})



// Avoiding weird behavior when pressing the enter key.
document.addEventListener('keydown', function(e){
    if(e.keyCode === 13){
        e.preventDefault();
    }
})
