<!DOCTYPE html>
<html>
    <body>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div>
                <h4>Media Card #<?php echo $_REQUEST['id']; ?></h4>
            </div>
            <div>
                Name: <input type="text" name="programName" id="programName" />
            </div>
            <div>
                Description: (optional) <br />
                <textarea name="programDescription" id="programDescription"></textarea>
            </div>
            <div>
                Select image to upload:
            </div>
            <div>
                <input type="file" name="upfile" id="upfile">
                <input type="hidden" name="programId" id="programId" value="<?php echo $_REQUEST['id']; ?>" />
                <input type="hidden" name="token" id="token" value="<?php echo $_REQUEST['token']; ?>" />
                
            </div>
            <div>
                <input type="submit" value="Upload Image" name="submit">
            </div>

        </form>
    </body>
</html>