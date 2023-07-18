class PopupDialog {
    ANIMATION_TIME = 300;

    submitEventCallback = (event) => {};

    openButton;
    closeButton;
    container;
    form;

    constructor (data) {
        this.initVariables(data);
        this.initActions();
    }

    initVariables (data) {
        this.openButton = document.getElementById(data.openBtId);
        this.closeButton = document.getElementById(data.closeBtId);
        this.container = document.getElementById(data.containerId);
        this.form = document.getElementById(data.formId);
        this.submitEventCallback = data.submitEventCallback;
    }

    initActions () {
        this.addOpenButtonAction();
        this.addCloseButtonAction();
        this.addFormAction();
    }

    addOpenButtonAction () {
        this.openButton.addEventListener("click", (e) => {
            this.open();
        });
    }

    addCloseButtonAction () {
        this.closeButton.addEventListener("click", (e) => {
            this.close();
        })
    }

    addFormAction () {
        this.form.addEventListener("submit", (e) => {
            this.close();
            this.submitEventCallback(e);
        });
    }

    open () {
        this.container.classList.add("dialog-container-visible");

        setTimeout(() => {
            this.container.children[0].classList.add("dialog-visible");
        }, 10);
    }

    close () {
        this.container.children[0].classList.remove("dialog-visible");

        setTimeout(() => {
            this.container.classList.remove("dialog-container-visible");
        }, this.ANIMATION_TIME);
    }
}