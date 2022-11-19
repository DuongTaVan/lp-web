function select() {
    let parentSelect = document.querySelector(".select");
    let valueSelected = document.querySelector(".select__value");
    let valueOptions = document.querySelectorAll(".select__item");
    for (let i = 0; i < valueOptions.length; i++) {
        valueOptions[i].classList.remove('item-active');
        if (valueSelected.value == valueOptions[i].textContent) {
            valueOptions[i].classList.add('item-active');
            valueOptions[i].scrollIntoView();
        }
    }
    parentSelect.classList.toggle("active");
}
function setValueSelect(e) {
    document.querySelector(".select__value").value = e.textContent;
}
document.body.addEventListener('mouseup', function (e) {
    if (e.target.closest('.select') === null) {
        let selectBox = document.querySelectorAll('.select')
        for (let i = 0; i < selectBox.length; i++) {
            selectBox[i].classList.remove('active');
        }
    }
});
