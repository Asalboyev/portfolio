var contactForm = document.querySelector('#contact_form');
let bot = {
  TOKEN: "5225193358:AAH9Rw3zlBsGbRtBZNKFz28LL_Fy1o6UFes",
  chatID: "-5008167286",
  
}
contactForm.addEventListener('submit', e => {
  e.preventDefault();
  var contact_name = document.querySelector('#contact_name');
  var contact_phone = document.querySelector('#contact_phone');
  var contact_messages = document.querySelector('#contact_messages');
  var time = new Date();
  time =  time.getDate()+"/"+time.getMonth()+"/"+time.getFullYear()+ "|" +time.getHours()+":"+time.getMinutes()+":"+time.getSeconds();
  messages = {
    messages_owner: contact_name,
    user_phone: contact_phone,
    user_messages: contact_messages,
    messages_time: time
  }
  fetch(`https://api.telegram.org/bot${bot.TOKEN}/sendMessage?chat_id=${bot.chatID}&text=${messages.messages_owner.value}%0A${messages.user_phone.value}%0A${messages.user_messages.value}%0A${messages.messages_time}`, {
    method: "GET"
  })
  .then(response => {
    alert("Xabar jo'natildi!")
  })
  .catch(error => {
    alert("Xabar jo'natilmadi!");
    console.log(error);
  })
})


fetch("https://t.me/sinifdoshlar_0_06/", {
	"method": "GET",
	"headers": {
		"content-type": "application/x-www-form-urlencoded",
		"x-rapidapi-key": "cf111325bfmsh670b85640838d3ap1d0acdjsnab7e9738ec84",
		"x-rapidapi-host": "nlp-translation.p.rapidapi.com"
	}
})
.then(response => {
	console.log(response);
})
.catch(err => {
	console.error(err);
});