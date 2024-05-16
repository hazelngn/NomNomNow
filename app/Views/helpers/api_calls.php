<script>
    /**
     * Fetches data from a specified table.
     * 
     * @param {string} name - The name of the table to fetch from.
     * @param {number} [id] - The ID of the item to fetch. If not provided, fetches all items.
     * @param {number} [pageNum] - The page number for pagination.
     * @param {number} [businessId] - The ID of the business to filter by.
     * @returns {Promise<Array|Object>} - The fetched data.
     */
    async function get(name, id, pageNum, businessId) {
        const baseUrl = `<?= base_url(); ?>/${name}`
        const url = id ? `${baseUrl}/${id}` : baseUrl;
        // Handle thepage for pagination
        let pagedUrl = pageNum ? `${url}?page=${pageNum}` : url;
        // Only returns the one with that business_id
        pagedUrl = businessId ? `${pagedUrl}&business_id=${businessId}` : pagedUrl;
        let result = [];

        await fetch(pagedUrl, {
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

    /**
     * Updates an item in a specified table.
     * 
     * @param {string} name - The name of the table to update.
     * @param {Object} data - The data to update, including the item ID.
     * @returns {Promise<Object>} - The updated data.
     */
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

    /**
     * Adds a new item to a specified table.
     * 
     * @param {string} name - The name of the table to add to.
     * @param {Object} data - The data of the new item to add.
     * @returns {Promise<Object>} - The added data.
     */
    async function add(name, data) {
        const url = `<?= base_url(); ?>/${name}`;
        let result = undefined;

        await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                [csrfName]: csrfHash
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (response.ok) {
                const newCsrfHash = response.headers.get(csrfName);
                if (newCsrfHash) {
                    console.log("new hash", newCsrfHash)
                    csrfHash = newCsrfHash;
                    document.querySelector('meta[name="csrf-token-value"]').setAttribute('content', csrfHash);
                }
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

    /**
     * Deletes an item from a specified table.
     * 
     * @param {string} name - The name of the table to delete from.
     * @param {number} id - The ID of the item to delete.
     * @returns {Promise<Object>} - The deleted data.
     */
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

