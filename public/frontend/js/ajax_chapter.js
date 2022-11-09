$(document).ready(function() {
     $(document).on('click', '.paginate a',function(e) {
                         e.preventDefault();
                         var page = $(this).attr('href').split('page=')[1];
                          $('#hidden_page').val(page);                      
                         var search_chapter=$('#search_page_chapter').val();
                         getPosts(page,search_chapter)
                   });

                   $(document).on('keyup', '#search_page_chapter',function(e) {
                       e.preventDefault();
                       var search_chapter=$('#search_page_chapter').val();
                       var page = $('#hidden_page').val()
                         getPosts(page,search_chapter)
                   });
                  
                   function getPosts(page,search_chapter)
                   {
                        $.ajax({
                             type: "GET",
                             url: '?page='+ page+'&search_chapter='+search_chapter
                        })
                        .success(function(data) {
                             $('#chapter_number').html('');
                             $('#chapter_number').html(data);
                        });

                   }
});