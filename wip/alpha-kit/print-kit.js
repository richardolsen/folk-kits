 async function main() {
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
  let myDiv = document.getElementById('code1')
  newCode = code.split('\n').map((line, index) => `${index + 1}. ${line}`).join('<br />');
  myDiv.innerHTML = newCode;

  let theTitle = document.getElementById('title1')
  theTitle.innerHTML = title;

  let theTagId= document.getElementById('tag1id')
  theTagId.innerHTML = "Program id: "+id;

  let createdDate = document.getElementById('created1')
  const d = new Date();
  let textDate = d.toDateString();
  let textTime = d.toLocaleTimeString();
  createdDate.innerHTML = "Updated: "+textDate+" "+textTime