document.getElementById('generateCodeBtn').addEventListener('click', function() {
    
    let code = generateCouponCode();

   
    checkUniqueCouponCode(code)
        .then(isUnique => {
            if (isUnique) {
                document.getElementById('code').value = code; 
            } else {
                alert('Coupon code already exists, generating a new one...');
               
                generateCodeBtn.click();
            }
        })
        .catch(error => {
            alert('Something went wrong while checking the coupon code.');
            console.error(error);
        });
});


function generateCouponCode() {
    const prefix = 'SALE'; 
    const randomString = Math.random().toString(36).substring(2, 10).toUpperCase(); 
    return `${prefix}-${randomString}`;
}


async function checkUniqueCouponCode(code) {
    try {
        const response = await fetch('/admin/coupons/check-unique-code', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ code: code })
        });

        const data = await response.json();
        return data.isUnique;
    } catch (error) {
        console.error('Error checking coupon code:', error);
        return false; 
    }
}

