<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Simple Crud With Ajax</title>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
  	<div class="container">
  		@yield('content')
  	</div>
  </body>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>


<script type="text/javascript">
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
  </script>


  <script type="text/javascript">


    //Edit Ajax Code with function
    $(document).on('click','.edit-modal',function()
    {
      $('#footer_action_button').text('Update');
      $('#footer_action_button').addClass('glyphicon-check');
      $('#footer_action_button').removeClass('glyphicon-trash');
      $('.actionBtn').addClass('btn btn-success');
      $('.actionBtn').removeClass('btn-danger');
      $('.actionBtn').addClass('edit');
      $('.modal-title').text('Edit');
      $('.deleteContent').hide();
      $('.form-horizontal').show();
      $('#fid').val($(this).data('id'));
      $('#t').val($(this).data('title'));
      $('#d').val($(this).data('description'));
      $('#myModal').modal('show');
    });

    $('.modal-footer').on('click','.edit',function()
    {
        $.ajax({


          type:'post',
          url:"{{ Route('editItem')}}",
          data:{
            '_token' : $('input[name_token]').val(),
            'id' : $('#fid').val(),
            'title' : $('#t').val(),
            'description' : $('#d').val()
          },
          success: function(data)
          {
            $('.item' + data.id).replaceWith("<tr class='item"+ data.id+"'><td>"+ data.id + "</td><td>" + data.title+"</td><td>" + data.description + "</td><td> <button class='edit-modal btn btn-info' data-id'" + data.id + "'data-title='" +data.title + "' data-description'" +data.description +"'><span class='glyphicon glyphicon-edit'></span> Edit </button> <button class='delete-modal btn btn-danger'  data-id='" + data.id + "'data-title='" +data.title + "' data-description='"  +data.description+ "'><span class='glyphicon glyphicon-trash'></span> Delete </button> </td></tr>");
          }
        });
    });


      //Add Data using Ajax
      $('#add').click(function()
      {
          $.ajax({
            type:'post',
            url:"{{ Route('addItem')}}",
            data:{
              '_token':$('input[name_token]').val(),
              'title':$('#title').val(),
              'description':$('#description').val()
            },
            success: function(data)
            {
              if((data.errors))
              {
                $('.error').removeClass('hidden');
                $('#error1').text(data.errors.title);
                $('#error2').text(data.errors.description);
              }
              else
              {
                $('.error').remove();
                $('.table').append("<tr class='item"+ data.id+"'><td>"+ data.id + "</td><td>" + data.title+"</td><td>" + data.description + "</td><td> <button class='edit-modal btn btn-info' data-id'" + data.id + "'data-title='" +data.title + "' data-description'" +data.description +"'><span class='glyphicon glyphicon-edit'></span> Edit </button> <button class='delete-modal btn btn-danger'  data-id='" + data.id + "'data-title='" +data.title + "' data-description='"  +data.description+ "'><span class='glyphicon glyphicon-trash'></span> Delete </button> </td></tr>");
              }
            }
          });

          $('#title').val('');
          $('#description').val('');
      });


     // Delete data using Ajax
      $(document).on('click','.delete-modal',function()
      {

        $('#footer_action_button').text('Delete');
         $('#footer_action_button').removeClass('glyphicon-check');
          $('#footer_action_button').addClass('glyphicon-trash');
          $('.actionBtn').removeClass('btn-success');
           $('.actionBtn').addClass('btn-danger');
          $('.actionBtn').addClass('delete');
           $('.modal-title').text('DELETE');
          $('.id').text($(this).data('id'));
          $('.deleteContent').show();
          $('.form-horizontal').hide();
          $('.title').html($(this).data('title'));
          $('#myModal').modal('show');


      });

      $('.modal-footer').on('click','.delete',function()
      {
          $.ajax({
            type:'post',
            url:"{{ Route('deleteItem')}}",
            data:
            {
              '_token':$('input[name-token]').val(),
              'id':$('.id').text()
            },
            success: function(data)
            {
              $('.item' + $('.id').text()).remove();
            }
          });
      });
  </script>
</html>
