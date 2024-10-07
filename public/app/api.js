(function () {

    const API = 'http://localhost/beesoft/api/public/api/e10/v1/';
    const tokenUrl = 'http://localhost/beesoft/api/public/sanctum/csrf-cookie';
    axios.interceptors.request.use((config) => {
        const token = localStorage.getItem('AUTH_TOKEN');
        config.headers.Authorization = `Bearer ${token}`;
        return config;
    });
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
                localStorage.setItem('user_id', response.data.data.user.id);
                localStorage.setItem('otc', response.data.data.otc);
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
            user_id: localStorage.getItem('user_id'),
        });
        if (response.status === 202) {
            localStorage.setItem('AUTH_TOKEN', response.data.data.access_token);
            console.log('OTP validation successful:', response.data);
        } else {
            console.error('OTP validation failed:', response.data);
        }
    }
    function insertOrg() {
        const payload = {
            name: 'new organization 1',
            post_office_address: 'p.o. box 112',
            phone: 44320823402,
            email: 'new_org@1.org',
            category: 1,
            account_status: 1,
            admin: 4,
        };
        const response = axios.post(API + 'super-admin/organizations', payload);
        if (response.status === 201 || response.status === 200) {
            // localStorage.setItem('AUTH_TOKEN', response.data);
            console.log(response.data);
        } else {
            console.error(response.data);
        }

    }
    function insertOrgLocation() {
       const  payload = {
            phone: 44320823402,
        };
        const response = axios.delete(API + 'super-admin/organizations/' + 2);
        if (response.status === 204) {
            console.log(response.data);
        } else {
            console.log(response);
        }
    }
    function getUser() {
        const response = axios.get(API + 'admin');
        if (response.status === 200) {
            document.writeln(response.data);
        } else {
            console.log(response);

        }
    }
    function logout() {
        localStorage.removeItem('AUTH_TOKEN');
        localStorage.removeItem('user_id');
        console.log('Logged out');
        const response = axios.post(API + 'logout');
        if (response.status === 204 || response.status === 200) {
            console.log('Logged out successfully');
        }
    }
    document.getElementById('test').addEventListener('click', function () {
        // validateOTC(localStorage.getItem('otc'));
        // login('admin@e10.app', '0549289243');
        // insertOrg();
        // logout();
        // validateOTC(272172);
        // logout();
        // getUser();
        insertOrgLocation();
    });

})()