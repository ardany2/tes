<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    
    <script src="../../js/jquery/jquery.min.js"></script>
    <script src="../../js/tinymce/tinymce.min.js"></script>
    <script src="../../js/tinymce-jquery/tinymce-jquery.min.js"></script>
    
  </head>
  <body>
    <form>
      <textarea id="tiny">&lt;p&gt;Welcome to the TinyMCE jQuery example!&lt;/p&gt;</textarea>
</form>
    <script>
      $('textarea').tinymce({
        height: 500,
        menubar: true,
        plugins: [
        "advlist", "anchor", "autolink", "charmap", "code", "fullscreen", 
        "help", "image", "insertdatetime", "link", "lists", "media", 
        "preview", "searchreplace", "table", "visualblocks", 
    ],
        toolbar: "undo redo | styles | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
      });
      
    </script>
    
  </body>
</html>