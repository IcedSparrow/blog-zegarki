$(".register-buttton").click(function(e) {
    e.preventDefault();
      $(".registred").slideDown(600);
         $(".wrapper").slideUp(600);
  });
  
  
  $(".reset").click(function(e) {
    e.preventDefault();
      $(".registred").slideUp(600);
         $(".wrapper").slideDown(600);
  });
  
  
  
  $(".btn").click(function(e) {
    e.preventDefault();
      $(".login--content").slideDown(600);
         $(".register--content").slideUp(600);
  });
  
  
  $(".btn-reg").click(function(e) {
    e.preventDefault();
      $(".login--content").slideUp(600);
         $(".register--content").slideDown(600);
  });