        $('.add-comment1').click(function(){
          

            if($(this).parent().find('#comment-message').val())
            {
               //$cf = $(this).parent().parent().parent().find('.comments');
                    $cff=$(this).parent(); 
                    $cf = $('.comments');               
                    var id = $(this).parent().find('input[name=comment_faq_id]').val();  
                    if($(this).parent().find('#comment_message-quote1').val())
                    {
                        
                        var datas = {
                                        'comment_post_ID': $(this).parent().find('input[name=comment_faq_id]').val(),
                                        'user_id': $(this).parent().find('input[name=comment_from]').val(),
                                        'comment_content': $(this).parent().find('#comment_message-quote1').val()+'</br>'+$(this).parent().find('#comment-message').val(),
                                        'comment_parent' : $(this).parent().find('input[name=comment_parent]').val(),
                                     };
                         var urls = JS_BASE_URL+'faq/addComment'; 
                             $.ajax({                   
                                        type:"POST",
                                        url:urls,
                                       data:datas,
                                       success:function(result){          
                                           $.get( JS_BASE_URL+'faq/loadComments/'+id, function(data){   
                                                $cf.html(data);                         
                                                $(window).resize();
                                                $(this).parent().find('#comment-message').val("");                       
                                                $cff.toggle();

                            
                                            });
                                        }
                                    });
                    }

                    else
                    {
                         var datas = {
                                        'comment_post_ID': $(this).parent().find('input[name=comment_faq_id]').val(),
                                        'user_id': $(this).parent().find('input[name=comment_from]').val(),
                                        'comment_content': $(this).parent().find('#comment-message').val(),
                                        'comment_parent' : $(this).parent().find('input[name=comment_parent]').val(),
                                     };
                         var urls = JS_BASE_URL+'faq/addComment'; 
                             $.ajax({                   
                                        type:"POST",
                                        url:urls,
                                       data:datas,
                                       success:function(result){          
                                           $.get( JS_BASE_URL+'faq/loadComments/'+id, function(data){   
                                                $cf.html(data);                         
                                                $(window).resize();
                                                $(this).parent().find('#comment-message').val("");
                                                $cff.toggle();

                            
                                            });
                                        }
                                    });
                    }

            }
            else
    {
        $(this).parent().append('<p class="error">Comment cannot be empty</p>');$(window).resize();
    }

        });




// for testimonial
        $('.add-comment2').click(function(){
          

            if($(this).parent().find('#comment-message').val())
            {
             
               //$cf = $(this).parent().parent().parent().find('.comments');
                    $cff=$(this).parent(); 
                    $cf = $(this).parents('.comments');        
                    var id = $(this).parent().find('input[name=comment_tes_id]').val();  
                    if($(this).parent().find('#comment_message-quote1').val())
                    {
                        
                        var datas = {
                                        'comment_testimonial_id': $(this).parent().find('input[name=comment_tes_id]').val(),
                                        'user_id': $(this).parent().find('input[name=comment_from]').val(),
                                        'comment_message': $(this).parent().find('#comment_message-quote1').val()+'</br>'+$(this).parent().find('#comment-message').val(),
                                        'comment_parent' : $(this).parent().find('input[name=comment_parent]').val(),
                                     };
                         var urls = JS_BASE_URL+'testimonialforum/addComment'; 
                             $.ajax({                   
                                        type:"POST",
                                        url:urls,
                                       data:datas,
                                       success:function(result){   

                                           $.get( JS_BASE_URL+'testimonialforum/loadComments/'+id, function(data){   
                                                $cf.html(data);                         
                                                $(window).resize(); 
                                                 $(this).parent().find('#comment-message').val("");                     
                                                $cff.toggle();


                            
                                            });
                                        }
                                    });
                    }

                    else
                    {
                        //alert($(this).parent().find('input[name=comment_tes_id]').val());
                         var datas = {
                                        'comment_testimonial_id': $(this).parent().find('input[name=comment_tes_id]').val(),
                                        'user_id': $(this).parent().find('input[name=comment_from]').val(),
                                        'comment_message': $(this).parent().find('#comment-message').val(),
                                        'comment_parent' : $(this).parent().find('input[name=comment_parent]').val(),
                                     };

                         var urls = JS_BASE_URL+'testimonialforum/addComment'; 
                             $.ajax({                   
                                        type:"POST",
                                        url:urls,
                                       data:datas,
                                       success:function(result){  
                                           $.get( JS_BASE_URL+'testimonialforum/loadComments/'+id, function(data){   
                                                $cf.html(data);                         
                                                $(window).resize();  
                                                $(this).parent().find('#comment-message').val("");                     
                                                $cff.toggle();

                                            });
                                        }
                                    });
                    }

            }
            else
    {
        $(this).parent().append('<p class="error">Comment cannot be empty</p>');$(window).resize();
    }

        });








