$('.fa-times.close').click(function () {
  $(this).closest('.toast').removeClass('active').addClass('hidden');
});

// multiple select2
$(function () {
  $("#multiSelect").each(function () {
      $(this).select2({
          theme: "bootstrap4",
          width: "style",
          placeholder: $(this).attr("placeholder"),
          allowClear: Boolean($(this).data("allow-clear")),
      });
  });
});
$(function () {
  $("#select2").each(function () {
      $(this).select2({
          theme: "bootstrap4",
          width: "style",
          placeholder: $(this).attr("placeholder"),
          allowClear: Boolean($(this).data("allow-clear")),
      });
  });
});
$(function () {
  $("#select_state").each(function () {
      $(this).select2({
          theme: "bootstrap4",
          width: "style",
          placeholder: $(this).attr("placeholder"),
          allowClear: Boolean($(this).data("allow-clear")),
      });
  });
});
$(function () {
  $("#select_designation").each(function () {
      $(this).select2({
          theme: "bootstrap4",
          width: "style",
          placeholder: $(this).attr("placeholder"),
          allowClear: Boolean($(this).data("allow-clear")),
      });
  });
});

// dropdown button
function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}
window.onclick = function (event) {
  if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
              openDropdown.classList.remove('show');
          }
      }
  }
}
// 
function myFunctionDrop() {
  document.getElementById("myDropdownfunction").classList.toggle("show");
}
window.onclick = function (event) {
  if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
              openDropdown.classList.remove('show');
          }
      }
  }
}
// image upload
$(".image-box").click(function (event) {
  var previewImg = $(this).children("img");

  $(this).siblings().children("input").trigger("click");

  $(this)
    .siblings()
    .children("input")
    .change(function () {
      var reader = new FileReader();

      reader.onload = function (e) {
        var urll = e.target.result;
        $(previewImg).attr("src", urll);
        previewImg.parent().css("background", "transparent");
        previewImg.show();
        previewImg.siblings("p").hide();
        previewImg.siblings(".upload_img").hide();
      };
      reader.readAsDataURL(this.files[0]);
    });
});

// ============= Side Menu
(function () {
  let sidebar = document.getElementById('drawerMenu');
  let sidebarOverlay = document.getElementsByClassName('sidebar-overlay')[0];
  let sidebarBtnClose = document.getElementById('drawerClose');
  let sidebarBtnOpen = document.getElementsByClassName('drawerOpen');

  let openSidebar = function () {
    sidebarOverlay.style.left = '0';
    sidebar.style.right = '0';
  }

  let closeSidebar = function (e) {
    e.cancelBubble = true;
    sidebarOverlay.style.left = '-100%';
    sidebar.style.right = '-100%';
  }

  sidebarOverlay.addEventListener('click', closeSidebar);
  sidebarBtnClose.addEventListener('click', closeSidebar);

  for (let i = 0; i < sidebarBtnOpen.length; i++) {
    sidebarBtnOpen[i].addEventListener('click', openSidebar);
  }
})();

// image upload in add candidate
$(document).ready(function () {
  function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
              $('#imagePreview').hide();
              $('#imagePreview').fadeIn(650);
          }
          reader.readAsDataURL(input.files[0]);
      }
  }
  $("#imageUpload").change(function () {
      readURL(this);
  });
});

//==== toast js
const button = document.querySelector("#toasted_btn"),
  toast = document.querySelector(".toast");
(closeIcon = document.querySelector(".toast .close")),
  (progress = document.querySelector(".toast .progress"));

let timer1, timer2;

button.addEventListener("click", () => {
  toast.classList.add("active");
  progress.classList.add("active");

  timer1 = setTimeout(() => {
    toast.classList.remove("active");
  }, 4000); //1s = 1000 milliseconds

  timer2 = setTimeout(() => {
    progress.classList.remove("active");
  }, 4300);
});

closeIcon.addEventListener("click", () => {
  toast.classList.remove("active");

  setTimeout(() => {
    progress.classList.remove("active");
  }, 300);

  clearTimeout(timer1);
  clearTimeout(timer2);
});

// tooltips
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

