var searchBox = document.getElementById('search');
var button = document.getElementById('do');
//grab elements for the textbox and the div that will ultimately host the results



button.addEventListener('click',function(){
    console.log('works here');
    
    // run ajax request to backend w the contents of the text box
    var xhr = new XMLHttpRequest();
    xhr.open('GET', `http://localhost/Git/Project_wcoding/hustleandgrind/index.php?action=display&xml=1`);

    xhr.addEventListener('readystatechange', function(){ 
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) { 
            obj = JSON.parse(xhr.response);
            console.log(obj);
            
            
        } else if (xhr.readyState === XMLHttpRequest.DONE && xhr.status !== 200 & xhr.status === 0){

            alert('there was an error \n\n Code:' + xhr.status + '\nText : ' + xhr.statusText);
            //just in case
        }

    });
    xhr.send(null);

});