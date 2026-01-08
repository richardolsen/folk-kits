<?php
    $programId = $_REQUEST["id"];

    $jsonFileName = "/home/folk/folk-data/kits/store/json/" . $programId . ".json";

    $myfile = fopen($jsonFileName, "r") or die("Error: Unable to open file!");
    $json = fread($myfile, filesize($jsonFileName));
    fclose($myfile);

    $program = json_decode($json);

    $programFileName = "/home/folk/folk-data/program/" . $programId . ".folk";
    $programfile = fopen($programFileName, "r") or die("Error: Unable to open file!");
    $code = fread($programfile, filesize($programFileName));
    fclose($programfile);

    $program->code = "<p>" . str_replace("\n", "</p><p>", $code) . "</p>";


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/apriltag@latest/dist/browser.js"></script>
    <body>
        <div class="container">
            <div class="row">
                <div class="col gap-0">

                    <div class="card" style="width: 15rem; height: 481px; overflow: hidden;">
                        
    <svg id="tag1" class="card-img" style="padding-top:10px;" viewBox="0 0 100 100" width="200" height="200" xmlns="http://www.w3.org/2000/svg"></svg>

        
                        
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $program->name; ?></h5>
                            <p class="card-text"><?php echo $program->description; ?></p>
                            <div class="image-container" style="height: 175px; overflow: hidden;">
                            <?php

                            $img_binary = fread(fopen($program->image, "r"), filesize($program->image));
                            $header_image = base64_encode($img_binary);
                            $img_tag = '<img src="data:image/png;base64,' . $header_image . '" alt="altText" class="card-img object-fit-cover w-100 h-100">';
                            echo $img_tag;
                            ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col gap-0">
                    <div class="card" style="width: 15rem; height: 481px; overflow: hidden;">
                        <div class="card-body">
                            <h5 class="card-title">Program #<?php echo $programId; ?></h5>
                            <p><?php echo $program->code; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                 async function main() {

                    var id = <?php echo $programId; ?>;

                    const rsp = await fetch('https://cdn.jsdelivr.net/npm/apriltag@latest/families/standard52h13.json')
                    const tagStandard52h13 = await rsp.json()

                    const family = new AprilTagFamily(tagStandard52h13)
                    tag = family.render(id)
                    console.log(tag)
                    for(r=0; r<tag.length;r++){
                    for(c=0; c<tag[r].length;c++){
                        let newElement = document.createElementNS('http://www.w3.org/2000/svg','rect');
                        if ( tag[r][c] == 'b'){
                        newElement.setAttribute('fill','black'); 
                        } else {
                        newElement.setAttribute('fill','white');
                        }
                        newElement.setAttribute('width','10');
                        newElement.setAttribute('height','10');
                        newElement.setAttribute('x',c*10);
                        newElement.setAttribute('y',r*10);
                        document.getElementById('tag1').appendChild(newElement);
                    }
                    }
                    
                }

                main()
            </script>
    </body>
</html>