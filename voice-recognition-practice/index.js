const btn = document.getElementById("btnStart");
const content = document.getElementById("content");

let speech = new webkitSpeechRecognition();
speech.lang = "ja";
speech.continuous = true;
speech.maxAlternatives = 1;

btn.addEventListener("click", () => {
  speech.start();
  btn.innerHTML = "音声認識中...";
});

speech.addEventListener("result", (e) => {
  let text = e.results[0][0].transcript;
  content.innerHTML = text;
  btn.innerHTML = "認識完了";
});
