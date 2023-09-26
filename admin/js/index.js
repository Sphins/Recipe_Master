
    function changeURL() {
        const selectedTable = document.getElementById('table').value;
        if (selectedTable !== "default") {
            const baseURL = "<?php echo ADMIN_ROOT; ?>";
            window.location.href = baseURL + "/table/show/" + selectedTable;
        }
    }
