var templateservicemod = angular.module('templateservicemod', []);
templateservicemod.service('TemplateService', function () {
    this.title = "Home";
    this.meta = "Google";
    this.metadesc = "Home";

    
    this.header = "views/header.html";
    this.menu = "views/menu.html";
    this.maincontent = "views/maincontent.html";
    this.content = "views/home.html";
    this.footer = "views/footer.html";
    this.dashboard = "views/dashboard.html";
    
    var d=new Date();
    this.year=d.getFullYear();
});