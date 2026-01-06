const ws = new FolkWS(document.getElementById('status'));
ws.watchCollected(tcl`program_id has error /something/ with info /errorInfo/`, errors => {
    errorEle.style.backgroundColor = errors.length ? "#f55" : "";
    errorEle.innerText = errors.map(e => e.errorInfo).join('\n');
});

    const fileInput = document.getElementById("file-input");
    const fileContentDisplay = document.getElementById("file-content");
    const messageDisplay = document.getElementById("message");
    const previewImg = document.getElementById("preview-image");

    fileInput.addEventListener("change", handleFileSelection);

    function handleFileSelection(event) {
        const file = event.target.files[0];
        fileContentDisplay.textContent = ""; // Clear previous file content
        messageDisplay.textContent = ""; // Clear previous messages

        // Validate file existence and type
        if (!file) {
            showMessage("No file selected. Please choose a file.", "error");
            return;
        }

        // Read the file
        const reader = new FileReader();
        reader.onload = () => {
            fileContentDisplay.textContent = reader.result;

        };

        reader.onerror = () => {
            showMessage("Error reading the file. Please try again.", "error");
        };
        reader.readAsText(file);
    }

        // Displays a message to the user
    function showMessage(message, type) {
        messageDisplay.textContent = message;
        messageDisplay.style.color = type === "error" ? "red" : "green";
    }


function handleUpload() {

    const fileName = document.getElementById("file-input").value;
    const fileContent = document.getElementById("file-content").textContent;
    console.log(fileContentDisplay.textContent);

    let fileObj = {name: fileName, content: fileContentDisplay.textContent}

    const fileJSON = JSON.stringify(fileObj)

    ws.send(tcl`
        set file_name "/home/folk/folk-data/kits/test-ws-ext.txt"
        set fp [open $file_name w]
        set fileContents {` + fileJSON + `}
        puts $fp $fileContents
        close $fp
    `);
}