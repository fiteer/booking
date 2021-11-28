

        <section id="footer">
        <div class="footer ">
            <div class="brand"><img src="images/logo22.png" alt=""></div>
            <div class="social-icon">
                <div class="social-item">
                    <a href="#"><img src="images/iconf.png" alt=""></a>
                </div>
                <div class="social-item">
                    <a href="#"><img src="images/iconw.png" alt=""></a>
                </div>
                <div class="social-item">
                    <a href="#"><img src="images/iconi.png" alt=""></a>
                </div>
                <div class="social-item">
                    <a href="#"><img src="images/icong.png" alt=""></a>
                </div>
            </div>
            <p>Copyright &copy 2021: <img src="images/logo22.png" alt=""></p>
        </div>
    </section>
            
        </div>
        <script src="<?php echo $js ?>jquery-3.5.1.min.js"></script>
        <script src="<?php echo $js ?>bootstrap.min.js"></script>
        <script src="<?php echo $js ?>jquery.selectBoxIt.min.js"></script>
        <script src="<?php echo $js ?>control.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    </body>
</html>

<style>
    .propress-label-left{
        float: left;
        margin-right: 0.5em;
        line-height: 1em;
    }
    .propress-label-right{
        float: right;
        margin-right: 0.5em;
        line-height: 1em;
    }
    .star-light{
        color: #e9ecef;
    }
</style>

<script>
    $(document).ready(function(){
        var rating_data = 0;
        $('#add_review').click(function(){
            $('#review_modal').modal('show');
        });

        $(document).on('mouseenter', '.submit_star', function(){
            var rating = $(this).data('rating');
            reset_background();
            for(var count = 1; count <= rating; count++){
				
                $('#submit_star_'+count).addClass('text-warning');
            }
        });

        function reset_background(){
            for(var count = 1; count <= 5; count++){
                $('#submit_star_'+count).addClass('star-light');
                $('#submit_star_'+count).removeClass('text-warning');
            }
        }
        $(document).on('mouseleave', 'submit_star', function(){
            reset_background();
        });

        $(document).on('click', '.submit_star', function(){
            rating_data = $(this).data('rating');
        });

        $('#save_review').click(function(){
            
            var user_review = $('#user_review').val();
            var item_id = $('#item_id').val();
            if(user_review == ''){
                alert("Please Fill Both Field");
                return false;
            }else{
                $.ajax({
                    url:"rating.php",
                    method:"POST",
                    data:{rating_data:rating_data, user_review:user_review, item_id:item_id},
                    success:function(data){
                        $('#review_modal').modal('hide');
                        alert(data);
                    }
                });
            }
        });
    });
</script>
