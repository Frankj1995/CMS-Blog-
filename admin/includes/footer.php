<!-- /#wrapper -->

<!-- jQuery -->
<script src="js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        ClassicEditor
            .create(document.querySelector('#body'))
            .catch(error => {
                console.error(error);
            });
    });
    
    $(document).ready(function() {
        var pusher = new Pusher('6401cbec95fe691b9962', {
            cluster: 'eu',
            encrypted: true
        });
        
        var channel = pusher.subscribe('notifications');
        
        channel.bind('new_user', function(notification) {
            var message = notification.message;
            toastr.success(`${message} just registered`);
        });
    })
</script>

</body>

</html>
