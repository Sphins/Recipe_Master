<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script>
    function changeURL() {
        const selectedTable = document.getElementById('table').value;
        if (selectedTable !== "default") {
            const baseURL = "<?php echo ADMIN_ROOT; ?>";
            window.location.href = baseURL + "/table/show/" + selectedTable;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        form.addEventListener('submit', function(event) {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            if (password && confirmPassword && password.value !== confirmPassword.value) {
                alert('Les mots de passe ne correspondent pas !');
                event.preventDefault();
            }
        });
    });

    function confirmDelete(deleteUrl) {
        var confirmation = confirm("Êtes-vous sûr de vouloir supprimer cet élément?");
        if (confirmation) {
            window.location.href = deleteUrl;
        }
    }
</script>