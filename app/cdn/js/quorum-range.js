
var myModalEl = document.getElementById('ModalChange')
myModalEl.addEventListener('shown.bs.modal', function (event) {

    var contributeRange = document.querySelector('#contributeRange');
    var myValue = document.querySelector('#contributeRangeValue');
    var thumbWidth = 20;
    
    var off = (contributeRange.clientWidth - thumbWidth) / (parseInt(contributeRange.max) - parseInt(contributeRange.min));
    var px = ((contributeRange.valueAsNumber - parseInt(contributeRange.min)) * off) - (myValue.clientWidth / 2) + (thumbWidth / 2);
    
    myValue.style.left = px + 'px';
    myValue.style.top = - 50 + 'px';
    myValue.innerHTML = `${contributeRange.value}%`;
    
    contributeRange.oninput = function() {
      let px = ((contributeRange.valueAsNumber - parseInt(contributeRange.min)) * off) - (myValue.clientWidth / 2) + (thumbWidth / 2);
      myValue.innerHTML = `${contributeRange.value}%`;
      myValue.style.left = px + 'px';
    };
    
});


$("#contributeRange").on('input', function(e){
var valPercent = (this.valueAsNumber  - parseInt(this.min)) / 
                    (parseInt(this.max) - parseInt(this.min));
    var style = 'background-image: -webkit-gradient(linear, 0% 0%, 100% 0%, color-stop('+ valPercent+', #3F16AE), color-stop('+ valPercent+', #3e16ae12));';
    this.style = style;
})