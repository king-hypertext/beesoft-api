(function () {

    const API = 'http://localhost/beesoft/api/public/api/e10/v1/';
    const tokenUrl = 'http://localhost/beesoft/api/public/sanctum/csrf-cookie';

    async function login(email, phoneNumber) {
        try {
            // Get CSRF token
            await axios.get(tokenUrl);

            // Login
            const response = await axios.post(API + 'login', {
                email,
                phone_number: phoneNumber,
            });

            if (response.status === 200) {
                console.log('Login successful:', response.data);
            } else {
                console.error('Login failed:', response.data);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    async function validateOTC(code) {
        const response = await axios.post(API + 'login/validate-otc', {
            otc: code,
            device: '',
            user_id: 1,
        });
        if (response.status === 200) {
            console.log('OTP validation successful:', response.data);
        } else {
            console.error('OTP validation failed:', response.data);
        }
    }
    document.getElementById('test').addEventListener('click', function () {
        validateOTC(565431);
        login('test@example.com', '+23209903920');
    });

})()