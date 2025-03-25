/**
 *
 * @module     theme_mb2mcl
 * @copyright  2017 - 2021 Mariusz Boloz (https://mb2themes.com)
 * @license    Commercial https://themeforest.net/licenses
 */ define(["jquery"],function(e){var r=function(r,s){var t=new Date,n=e(".php2js").attr("data-scp");t.setTime(t.getTime()+2592e5);var a="expires="+t.toUTCString();document.cookie=r+"="+s+"; "+a+"; path="+n};return{sePreference:function(s,t){return e("body").hasClass("css_31a2")&&e("body").hasClass("nouser")?r(s,t):e("body").hasClass("css_31a2")?void require(["core_user/repository"],function(e){return e.setUserPreference(s,t)}):M.util.set_user_preference(s,t)}}});