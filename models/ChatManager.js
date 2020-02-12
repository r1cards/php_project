function sendMessage() {

    let message = (document.getElementById('chatMessage')).value;
    let receiver = (document.getElementById('receiverId')).value;
    let sender = (document.getElementById('senderId')).value;

    // Using these keys yo can access the data in your php file
    let data = "message="+message;
    data += "&receiver="+receiver;
    data += "&sender="+sender;

    let xhttp = new XMLHttpRequest();
    xhttp.open("POST","models/ChatController.php",true);
    // This is only for post
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
    // This is basically a listener for when data gets retuned in this case data is not retuned because it is a post
    xhttp.onreadystatechange = function () {
        // This will be executed after the code in php has been executed
        if(this.readyState === 4 && this.status === 200){
            getMessages(receiver, sender);
            // console.log(this.responseText);
        }
    }
}

function getMessages(receiverId, senderId) {
    let url = "models/ChatController.php?requestName=getNewMessages";
    url += "&receiverId=" + receiverId;
    url += "&senderId=" + senderId;
    // How to compose a get request
    let xhttp = new XMLHttpRequest();
    xhttp.open("GET", url, true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
        // This will be executed after the code in php has been executed
        if(this.readyState === 4 && this.status === 200){
            // This is how you convert to JSON data
            let jsonData = JSON.parse(this.responseText);
            // Just to see if it works
            // console.log(jsonData);
           let messageContainer = document.getElementById('messages');
           // loops through the elements of the JSON array
           jsonData.forEach((message)=>{
               // create a paragraph
               let messageView = document.createElement("p");
               // add the text to the paragraph from the JSON array
               messageView.innerText = message.message_content;
               // adds it tot the container
               messageContainer.appendChild(messageView);
           })
        }
    }
}