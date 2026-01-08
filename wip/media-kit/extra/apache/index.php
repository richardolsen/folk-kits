<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <body>
        <div class="container">
            <form action="upload.php" method="post" enctype="multipart/form-data">
           
                    <div class="mb-3">
                        <h4>Media Card #<?php echo $_REQUEST['id']; ?></h4>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name:</label> <input type="text" name="programName" id="programName" class="form-control" />
                    </div>
                    <div class="mb-3">
                        Description: (optional) <br />
                        <textarea name="programDescription" id="programDescription" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        Select image to upload:
                    </div>
                    <div class="mb-3">
                        <input type="file" name="upfile" id="upfile" class="form-control">
                        <input type="hidden" name="programId" id="programId" value="<?php echo $_REQUEST['id']; ?>" />
                        <input type="hidden" name="token" id="token" value="<?php echo $_REQUEST['token']; ?>" />
                        
                    </div>
                    <div class="mb-3">
                        <button type="submit" value="Upload Image" name="submit" class="btn btn-primary">Submit</button>
                    </div>
      
            </form>
        </div>
    </body>
</html>