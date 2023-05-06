<!DOCTYPE html>
<html>
<head>
  <script src="https://cdn.tiny.cloud/1/p8y5shd5vcv2u35b0t6f7coi9hyfxw5cz4smpg9pohlgckks/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>
    <form method="post" action="<?=$_SERVER['REQUEST_URI']?>">
  <textarea>
    
  </textarea>
  <input type="submit" name="save" value="Submit" />
</form>
  <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'a11ychecker advcode casechange export formatpainter image editimage linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tableofcontents tinycomments tinymcespellchecker',
      toolbar: 'a11ycheck addcomment showcomments casechange checklist code export formatpainter image editimage pageembed permanentpen table tableofcontents',
      toolbar_mode: 'floating',
      language: 'pl',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Author name',
    });
  </script>
</body>
</html>