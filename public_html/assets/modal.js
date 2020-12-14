'use strict';
class Modal {
  modal(title, text) {
    $(".p-modal").addClass("block");
    if (title!=="") {
      $(".c-modal__title").addClass("block");
      $(".c-modal__title").text(title);
    }
    if (text!=="") {
      $(".c-modal__text").addClass("block");
      $(".c-modal__text").text(text);
    }
    $(".c-modal__button").click(function() {
      $(".p-modal").removeClass("block");
    });
  }

  errormodal(title, text) {
    $(".p-modal").addClass("block");
    $(".c-modal__icon").addClass("block");
    if (title!=="") {
      $(".c-modal__title").addClass("block");
      $(".c-modal__title").text(title);
    }
    if (text!=="") {
      $(".c-modal__text").addClass("block");
      $(".c-modal__text").text(text);
    }
    $(".c-modal__button").click(function() {
      $(".p-modal").removeClass("block");
    });
  }
}
export default Modal;
