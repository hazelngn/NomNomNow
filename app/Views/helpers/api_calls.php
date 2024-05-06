<script>
    // name: table to fetch from
    async function get(name, id) {
        const baseUrl = `<?= base_url(); ?>/${name}`
        const url = id ? `${baseUrl}/${id}` : baseUrl;
        let result = [];

        await fetch(url, {
            method: 'GET',
            headers: {'Content-Type': 'application/json'},
        })
        .then(response => {
            if (response.ok) {
                return response.json()
            }
        })
        .then(data => {
            // Additional logic to update the table or clear the form goes here
            result = data;
        })
        .catch(error => {
            result = [];
        });

        return result
    }

    async function update(name, data) {
        const url = `<?= base_url(); ?>/${name}/${data.id}`;
        let result = undefined;

        await fetch(url, {
            method: 'PUT',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        })
        .then(response => {
            if (response.ok) {
                return response.json()
            }
        })
        .then(data => {
            // Additional logic to update the table or clear the form goes here
            // success
            result = data;
        })
        .catch(error => {
            console.log("An error has occurred. The error is: " + error);
        });

        return result
    }

    async function add(name, data) {
        const url = `<?= base_url(); ?>/${name}`;
        let result = undefined;

        await fetch(url, {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        })
        .then(response => {
            if (response.ok) {
                return response.json()
            }
        })
        .then(data => {
            // Additional logic to update the table or clear the form goes here
            // success
            result = data;
        })
        .catch(error => {
            console.log("An error has occurred. The error is: " + error);
        });

        return result
    }

    async function deleteItem(name, id) {
        const url = `<?= base_url(); ?>/${name}/${id}`;
        let result = undefined;

        await fetch(url, {
            method: 'DELETE',
            headers: {'Content-Type': 'application/json'},
        })
        .then(response => {
            if (response.ok) {
                return response.json()
            }
        })
        .then(data => {
            // Additional logic to update the table or clear the form goes here
            // success
            result = data;
        })
        .catch(error => {
            console.log("An error has occurred. The error is: " + error);
        });

        return result
    }
</script>

