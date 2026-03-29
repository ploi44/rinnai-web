/************************************************************************************/
/*	Constants - 定数																			*/
/************************************************************************************/
const E_OK = 0; //Normal response - 正常応答
const HEADER_CLASS = "header"; //Header element ID - ヘッダー要素につけるID
const PAGE_TOP_ID = "#pagetop"; //Page top ID - ページトップのID
const CLICK_AERA_CLASS = ".js-click_area"; //Click area - クリックエリア
/*	Auto set file extension - 拡張子自動設定	*/
const EXTENSION_PDF_CLASS = ".extension-pdf";
const EXTENSION_DOC_CLASS = ".extension-doc";
const EXTENSION_XLS_CLASS = ".extension-xls";
const EXTENSION_MP3_CLASS = ".extension-mp3";
const EXTENSION_MP4_CLASS = ".extension-mp4";
const STICKY_SIDEBAR_ID = "#js-sticky_sidebar";
/*	Accordion settings - アコーディオン設定	*/
const ACODION_ACTIVE_CLASS = ".js-aco_active";
const ACODION_TARGET_CLASS = ".aco";
const ACODION_DEFAULT_STATE = "close"; //close for initial hidden state - 初期表示閉じる場合はclose。
const ACIDION_SLIDE_SPEED = 200; //Slide speed (ms) - スライドのスピード（ミリ秒）
/*	Scroll-related settings - スクロール関連設定	*/
const SCROLL_TOP_CLASS = "scroll_top"; //.None - なし
//const SCROLL_MID_CLASS = 'scroll_mid';			//.None - なし
const SCROLL_MID_CLASS = "thin"; //.None - なし
const SCROLL_BOTTOM_CLASS = "scroll_bottom";
const SCROLL_AREA_TOP = 80; //Scroll top class range - スクロールトップのクラスをつける範囲
const SCROLL_AREA_BOTTOM = 0; //Scroll bottom class range - スクロールボトムのクラスをつける範囲
const SCROLL_UP_CLASS = "scroll_up"; //.None - なし
const SCROLL_DOWN_CLASS = "scroll_down"; //.None - なし
const IGNORE_CLASS = "no-scroll"; //Smooth scroll exclusion class - するするスクロール除外クラス
const SCROLL_SPEED = 300;
const SCROLL_BOTTOM_ACTION = false; //Execute when reaching bottom - 一番下に行ったときに処理するか？
/*	Display toggle settings - 表示切替系	*/
const DISPLAY_SWITCH_CONTROLLER_CLASS = ".js-ds_switch_controll";
const DISPLAY_SWITCH_TARGET_CLASS = ".js-ds_switch_target";
/*	Desktop or mobile device related - PC/SP関連	*/
const TABLET_MODE = true; //boolean
const DEVICE_JUDGE_TYPE = "ua"; //'width' or 'ua' If TABLET_MODE is true, specify ua - TABLET_MODEがtrueの時はuaを指定してください。
const BREAK_POINT_SP = 480;
const DEVICE_PC_CLASS = "js-device_pc"; //. None - なし
const DEVICE_SP_CLASS = "js-device_sp"; //.None - なし
const DEVICE_TABLET_CLASS = "js-device_tablet"; //.None - なし
const WINDOW_RATIO_PORTRAIT = "js-win_portrait"; //.None - なし
const WINDOW_RATIO_LANDSCAPE = "js-win_landscape"; //.None - なし
const HOVER_CLASS = "hover";
/************************************************************************************/
/*	Global variables - グローバル変数																	*/
/************************************************************************************/
var ScrollPosition = 0;
var ScrollAreaBottom = 0;
var ScrollShift = 0;
var GlobalPageSetting = {};

/************************************************************************************/
/*	Library initialization - ライブラリの初期化																*/
/************************************************************************************/
//Avoiding Errors During jQuery Dynamic Loading - jQuery動的読み込み時のエラー回避
window.onerror = TigilError;
function TigilError() {
  return true;
}
//Infinite loop until jQuery finishes loading - jQueryの読み込みが完了するまで無限ループ
let jq_looder_counter = 0;
let jq_loader_loop = setInterval(function () {
  if ($ !== undefined) {
    jq_looder_counter++;
    if (jq_looder_counter > 500) {
      //Cancel the process if loading takes over 5 seconds - 5秒で読めなかったら処理中止
      clearInterval(jq_loader_loop);
      console.error("jQuery Loading Error...");
    }
    clearInterval(jq_loader_loop);
    $(function () {
      InitLibrary(); //Library initialization ライブラリの初期化関数
      ProjectInit(); //Project-specific initialization function プロジェクト固有の初期化関数
    });
  }
}, 10);
/************************************************************************************/
/*	Project-specific logic goes here プロジェクト固有の処理はここに書く												*/
/************************************************************************************/
function ProjectInit() {
  // Tablet detection タブレット判定
  var ua = navigator.userAgent;
  if ((ua.indexOf("Android") > 0 && ua.indexOf("Mobile") == -1) || ua.indexOf("iPad") > 0 || ua.indexOf("Kindle") > 0 || ua.indexOf("Silk") > 0) {
    $("body").addClass("tablet");
  }

  var urlHash = location.hash.split("?")[0];
  if (urlHash) {
    let scroll_speed = 500;
    if (get_url_param("scrollspeed") != null) {
      scroll_speed = Number(get_url_param("scrollspeed"));
    }
    $("body,html").stop().scrollTop(0);
    setTimeout(function () {
      var target = $(urlHash);
      if ((navigator.userAgent.indexOf("iPhone") > 0 && navigator.userAgent.indexOf("iPad") == -1) || navigator.userAgent.indexOf("iPod") > 0 || navigator.userAgent.indexOf("Android") > 0) {
        var position = target.offset().top - 40;
      } else {
        var position = target.offset().top - 60;
      }
      $("body,html").stop().animate(
        {
          scrollTop: position,
        },
        scroll_speed
      );
    }, 500);
  }

  // IE11はsvg画像ではなくpng画像を使うようにする処理(アニメーションでチカチカしたり不具合が出るため)
  if (navigator.userAgent.indexOf("Trident") !== -1) {
    $("img[src$='.svg']").each(function () {
      $(this).attr("src", $(this).attr("src").replace(".svg", ".png"));
    });
  }

  NavController.init();
  EntranceNav.init("nav.entrance");
}

//第二階層 新着情報 一定期間表示
$(document).ready(function () {
  var currentDate = new Date();
  $(".newmarkList").each(function () {
    var pass = 8760; // passage time(24時間×365日=8760)
    var newmarkAttr = $(this).attr("data-time");
    newmarkAttr = newmarkAttr.replace(/年|月|日|時|分/g, ":");
    newmarkAttr = newmarkAttr.replace(/\s|秒.*/g, "");
    var time = newmarkAttr.split(":");
    var entryDate = new Date(time[0], time[1] - 1, time[2], time[3], time[4], time[5]);
    var now = (currentDate.getTime() - entryDate.getTime()) / (60 * 60 * 1000);
    now = Math.ceil(now);
    if (now <= pass) {
      $(this).show();
    } else {
      $(this).hide();
    }
  });
});

// Common - 共通
const navCore = {
  _scrollPos: 0,
  _overlay: null,
  _hadThin: false,
  _hadScrollTop: false,
  _isLocked: false,

  _ensureOverlay() {
    if (!this._overlay) {
      this._overlay = $('<div class="global-nav-overlay" />').hide().appendTo("body");
    }
    return this._overlay;
  },
  lockBody() {
    if (this._isLocked) return; // Double lock prevention - 二重ロック防止
    this._isLocked = true;
    const THIN = typeof SCROLL_MID_CLASS !== "undefined" && SCROLL_MID_CLASS ? SCROLL_MID_CLASS : "thin";
    this._scrollPos = $(window).scrollTop();

    // Record the current state - 現在の状態を記録
    this._hadThin = $("body").hasClass(THIN);
    this._hadScrollTop = $("body").hasClass("scroll_top");

    // Navigation Open Flag (For guarding other logic) - ナビ開放中フラグ（他ロジック側のガード用）
    $("body").addClass("is-globalnav-open");

    // Scroll Lock - スクロール固定
    $("body").css({ position: "fixed", top: -this._scrollPos, width: "100%" });

    // Protection: Maintain thin, temporarily remove scroll_top - 保護：thin を維持、scroll_top は一時的に外す
    if (this._hadThin) $("body").addClass(THIN);
    $("body").removeClass("scroll_top");

    // Correct even if overwritten by another handler after clicking - クリック後に他ハンドラで書き換えられても矯正
    setTimeout(() => {
      if (this._hadThin) $("body").addClass(THIN);
      $("body").removeClass("scroll_top");
    }, 0);
  },
  unlockBody() {
    if (!this._isLocked) return;
    // Unlock scroll - スクロール固定解除
    $('body').css({ position: '', top: '', width: '' });
    window.scrollTo(0, this._scrollPos);

    // Flag removal (do not touch thin/scroll_top) - フラグ解除（thin/scroll_top は触らない）
    $('body').removeClass('is-globalnav-open');

    this._isLocked = false;
  },
  open($li, $menu) {
    $menu.data('state', 'opening');
    if (!$li || !$menu || !$menu.length) return;
    if ($li.data("busy") || $menu.data("busy")) return;

    const reduce = window.matchMedia && window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    $li.data("busy", true);
    $menu.data("busy", true);

    // ARIA and Icon Updates - ARIA とアイコンの更新
    $li.find("> a, > button").attr("aria-expanded", "true");
    const $icon = $li.find("> a > .cmn-icon.icon-arrow");
    if ($icon.length) {
      $icon.removeClass("-down").addClass("-up").attr("aria-label", "Close the menu");
    }

    // Initial style - 初期スタイル
    $menu.stop(true, false).css({
      height: 0,
      overflow: "hidden",
      display: "block",
    });
    $li.addClass("is_active");

    const naturalHeightPx = $menu[0].scrollHeight || 0;
    const isSPViewport = !window.matchMedia('(min-width:1245px)').matches;
    // Menu type - メニュー種別
    const isSearchMenu = $menu.is('.rinnaiglobalHeader_dropDownMenu.-search');
    const isLangMenu   = $menu.is('.rinnaiGlobalHeader_navi_language');
    const isHamburger  = $menu.is('.rinnaiglobalHeader_dropDownMenu') && !isSearchMenu;
    // Viewport height (including address bar) - 表示中のビューポート高（アドレスバー考慮）
    const vh = (window.visualViewport && window.visualViewport.height) || window.innerHeight;
    // Top edge of the panel (minus the portion extending below the header) - パネルの上端（ヘッダー下から出るぶんを差し引く）
    const top = $menu[0].getBoundingClientRect().top;
    // Maximum: SP and (language or hamburger) = “remaining height”, otherwise = 80vh - 上限：SP かつ（言語orハンバーガー）＝「残り高さ」、それ以外＝80vh
    const maxOpenPx = (isSPViewport && (isLangMenu || isHamburger))
      ? Math.max(0, vh - top)                    // to the bottom - 画面下まで
      : Math.floor(vh * 0.8);                    // 従来の 80vh
    const targetHeightPx = (isSPViewport && (isLangMenu || isHamburger))
    ? Math.max(0, vh - top)   // For mobile, Language/Hamburger menu opens until at the bottom - SPの言語/ハンバーガーは常に画面下まで
    : Math.min(naturalHeightPx, maxOpenPx);

    if (reduce) {
      // Layout remains unchanged during motion reduction (desktop: auto height; mobile: language/hamburger menu fixed at remaining height) - モーション軽減時もレイアウトは同じ（PCは自動高さ、SP言語/ハンバーガーは残り高さで固定）
      const vh  = (window.visualViewport && window.visualViewport.height) || window.innerHeight;
      const top = $menu[0].getBoundingClientRect().top;
      if (isSPViewport && (isLangMenu || isHamburger)) {
        $menu.css({ height: Math.max(0, vh - top) + 'px', overflow: 'auto' });
      } else {
        $menu.css({ height: "", overflow: "" });
      }
      $li.data("busy", false);
      $menu.data("busy", false);
      $menu.data("state", "open");
      return;
    }
    // Reset submenu scroll position to top each time it opens - ★開くたびにサブメニューのスクロールを先頭へ
    //   - When the $menu itself scrolls - $menu 自体がスクロールするケース
    //   - Apply to inner scroll wrappers (candidates) as a precaution - 内側のスクロール用ラッパ（候補）にも一応かけておく
    const $scrollRoots = $menu
      .filter(function(){ return this.scrollHeight > this.clientHeight; })
      .add($menu.find('.inner, .scroll-area, [data-scroll-root]'));
    $scrollRoots.scrollTop(0);
    // Animation - アニメーション
    requestAnimationFrame(() => {
      $menu.css({
        transition: "height 800ms ease",
        willChange: "height",
        height: targetHeightPx + "px",
      });

      const onEnd = (e) => {
        if (e && e.target !== $menu[0]) return;
        // $menu.off("transitionend", onEnd).css({ transition: "", willChange: "", height: "", overflow: "" });
        $menu.off("transitionend", onEnd).css({ transition: "", willChange: "" });
        if (isSPViewport && (isLangMenu || isHamburger)) {
          const vh = (window.visualViewport && window.visualViewport.height) || window.innerHeight;
          const top = $menu[0].getBoundingClientRect().top;
          $menu.css({ height: Math.max(0, vh - top) + 'px', overflow: 'auto' });
        } else {
          $menu.css({ height: "", overflow: "" });
        }
        $li.data("busy", false);
        $menu.data("busy", false);
        $menu.data('state', 'open');
      };

      $menu.on("transitionend", onEnd);
    });
  },
  close($li, $menu) {
    if (!$li || !$menu || !$menu.length) return;
    if ($li.data('busy') || $menu.data('busy')) {
      if ($menu.data('state') === 'opening') {
        $menu.one('transitionend.navForceClose', () => { this.close($li, $menu); });
      }
      return;
    }
    $menu.css({ transition: "height 500ms ease", willChange: "height" });
    const reduce = window.matchMedia && window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    $li.data("busy", true);
    $menu.data("busy", true);

    const $icon = $li.find("> a > .cmn-icon.icon-arrow");
    if ($icon.length) {
      $icon.removeClass("-up").addClass("-down").attr("aria-label", "Open the menu");
    }
    $li.find("> a, > button").attr("aria-expanded", "false");

    const cur = $menu[0].scrollHeight || $menu.outerHeight();
    $menu.stop(true, false).css({ overflow: "hidden", height: cur });

    $menu.data('state', 'closing');
    const finish = () => {
      $menu.css({ height: "", overflow: "", display: "none" });
      $li.removeClass("is_active");
      $li.data("busy", false);
      $menu.data("busy", false);
      $menu.data('state', 'closed');
      //  Close Completion Event (For overlay control on desktop) - ★ クローズ完了イベント（PC側でのオーバーレイ制御用）
      $menu.trigger("nav.closed");
    };

    if (reduce) {
      finish();
      return;
    }
    void $menu[0].offsetHeight;
    $menu.css({ transition: "height 500ms ease", willChange: "height", height: 0 });
    const onEnd = (e) => {
      if (e && e.target !== $menu[0]) return;
      $menu.off("transitionend", onEnd).css({ transition: "", willChange: "" });
      finish();
    };
    $menu.on("transitionend", onEnd);
  },
  setCurrent($ul) {
    if (!$ul || !$ul.length) return;
    const normalize = (p) =>
      String(p || "")
        .replace(/\/index\.html?$/i, "")
        .replace(/\/$/, "");
    const isSameOrigin = (a) => {
      try {
        return a.prop("origin") ? a.prop("origin") === window.location.origin : true;
      } catch (e) {
        return true;
      }
    };
    const currentPath = normalize(window.location.pathname);
    $ul.find("> li").each(function () {
      const $li = $(this);
      const $top = $li.find("> a[href], > button[href]").first();
      if ($top.length && isSameOrigin($top)) {
        const topPath = normalize($top.prop("pathname"));
        if (topPath && topPath === currentPath) {
          $li.addClass("is_current");
          return;
        }
      }
      let matched = false;
      $li.find(".rinnaiglobalHeader_dropDownMenu a[href]").each(function () {
        const $a = $(this);
        if (!isSameOrigin($a)) return;
        if (normalize($a.prop("pathname")) === currentPath) {
          matched = true;
          return false;
        }
      });
      if (matched) $li.addClass("is_current");
    });
  },
};

// For desktop - PC 専用
const GlobalNavPC = (() => {
  let $root, onDocClick, hadThinOnOpen = false;
  let switching = false;
  // Highlight the current page link in the submenu - PC: サブメニュー内の現在ページリンクをハイライト
  function markPCCurrentLinks($scope) {
    if (!$scope || !$scope.length) return;
    const normalize = (p) =>
      String(p || "")
        .replace(/\/index\.html?$/i, "")
        .replace(/\/$/, "");
    const currentPath = normalize(window.location.pathname);
    $scope.find(".rinnaiglobalHeader_dropDownMenu a[href]").each(function () {
      const $a = $(this);
      const rawHref = ($a.attr("href") || "").trim();
      // Exclude invalid links (empty/hash/javascript/mailto/tel) - 無効リンクを除外（空/ハッシュ/javascript/mailto/tel）
      if (!rawHref || rawHref === "#" || rawHref.startsWith("#") || /^javascript:/i.test(rawHref) || /^mailto:/i.test(rawHref) || /^tel:/i.test(rawHref)) return;
      let url;
      try {
        url = new URL(rawHref, window.location.href);
      } catch (_e) {
        return;
      }
      if (url.origin !== window.location.origin) return; // Same origin only - 同一オリジンのみ
      if (normalize(url.pathname) === currentPath) {
        $a.addClass("is_current").attr("aria-current", "page");
      }
    });
  }
  function closeAll() {
    $root.find("> li.is_active").each(function () {
      const $li = $(this);
      const $menu = $li.children(".rinnaiglobalHeader_dropDownMenu, .rinnaiGlobalHeader_navi_language");
      navCore.close($li, $menu);
    });
  }
  function init() {
    $root = $(".rinnaiGlobalHeader_navi_global nav.global > ul, .rinnaiGlobalHeader_navi_top nav.select > ul");
    navCore.setCurrent($root);
    // Add is_current/aria-current to the current page link within the submenu - PC: サブメニュー内の現在ページリンクに is_current/aria-current を付与
    markPCCurrentLinks($root);

    // Hide everything first - 先に全部隠す
    $root.find(".rinnaiglobalHeader_dropDownMenu, .rinnaiGlobalHeader_navi_language").hide();

    // Toggle - トグル
    $root.off("click.pc").on("click.pc", "> li > a:not(.ignore), > li > button", function (e) {
      if (switching) { e.preventDefault(); e.stopPropagation(); return; }
      const $anchor = $(this);
      const $li = $anchor.closest("li");
      const $menu = $anchor.next(".rinnaiglobalHeader_dropDownMenu, .rinnaiGlobalHeader_navi_language");
      if (!$menu.length) return; // Single link - 単リンク
      e.preventDefault();
      e.stopPropagation();

      if ($li.hasClass("is_active")) {
        switching = true;
        navCore.close($li, $menu);
        // Release the overlay and scroll lock after closing - クローズ完了後にオーバーレイとスクロールロックを解除
        navCore._ensureOverlay().hide();
        $menu.one("nav.closed", () => {
          switching = false;
          if (!$root.find("> li.is_active").length) {
            navCore.unlockBody();
            // If narrow before opening, keep thin - 開く前にナローだった場合、thinを維持
            if (hadThinOnOpen) $("body").addClass(SCROLL_MID_CLASS);
          }
        });
      } else {
        switching = true;
        // Close all other open menus first, then wait for the close operation to complete (nav.closed) before opening - 先に開いている他メニューをすべて閉じ、クローズ完了(nav.closed)を待ってから開く
        const $others = $root.find('> li.is_active').not($li);
        const openTarget = () => {
          // If necessary, retain thin - 必要なら thin を保持（既存仕様を踏襲）
          hadThinOnOpen = $('body').hasClass(SCROLL_MID_CLASS);
          if (hadThinOnOpen) $('body').addClass(SCROLL_MID_CLASS);
          navCore.lockBody();
          navCore._ensureOverlay().show();
          navCore.open($li, $menu);
          const reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
          if (reduce) {
            switching = false;
          } else {
            $menu.one('transitionend.navOpenDone', () => { switching = false; });
          }
        };
        if (!$others.length) { openTarget(); return; }
        let remaining = 0;
        $others.each(function(){
          const $x = $(this);
          const $m = $x.children('.rinnaiglobalHeader_dropDownMenu, .rinnaiGlobalHeader_navi_language');
          if (!$m.length) return;
          remaining++;
          // Wait for closure completion - クローズ完了を待つ
          $m.one('nav.closed', () => { if (--remaining === 0) openTarget(); });
          // If not in progress, begin closing process - 進行中でなければ閉じ処理を開始
          // if (!$x.data('busy') && !$m.data('busy')) navCore.close($x, $m);
          navCore.close($x, $m);
        });
      }
    });

    // Close button in the submenu (include search) - サブメニュー内の閉じるボタン（検索含む）
    $root
      .find(".search_close, .menu_close")
      .off("click.pc")
      .on("click.pc", function (e) {
        e.preventDefault();
        e.stopPropagation();
        const $li = $(this).closest("li");
        const $menu = $li.children(".rinnaiglobalHeader_dropDownMenu, .rinnaiGlobalHeader_navi_language");
        if (!$menu.length) return;
        navCore.close($li, $menu);
        navCore._ensureOverlay().hide();
        // After closing, if no other menus are open, disable overlay/scroll lock - クローズ完了後に、他に開いているものが無ければオーバーレイ/スクロールロックを解除
        $menu.one("nav.closed", () => {
          if (!$root.find("> li.is_active").length) {
            navCore.unlockBody();
          }
        });
      });

    // Outer Click - 外側クリック
    onDocClick = (e) => {
      const $ov = navCore._ensureOverlay();
      if ($(e.target).closest($root).length) return;
      const anyOpen = $root.find("> li.is_active").length > 0;
      if (!anyOpen && !navCore._isLocked) return;
      closeAll();
      $ov.hide();
      navCore.unlockBody();
      // If narrow before opening, keep thin - 開く前にナローだった場合、thinを維持
      if (hadThinOnOpen) $("body").addClass(SCROLL_MID_CLASS);
    };
    $(document).on("click.pc", onDocClick);
  }
  function destroy() {
    if (!$root) return;
    $(document).off("click.pc", onDocClick);
    $root.off("click.pc");
    $root.find(".search_close").off("click.pc");
    // Close if opened - 開いていたら閉じる
    $root.find("> li.is_active").removeClass("is_active").children(".rinnaiglobalHeader_dropDownMenu, .rinnaiGlobalHeader_navi_language").hide();
    navCore._ensureOverlay().hide();
    navCore.unlockBody();
  }
  return { init, destroy };
})();

// For mobile - SP 専用
const GlobalNavSP = (() => {
  let $root;
  let switching = false;
  function init() {
    $root = $(".sp .rinnaiGlobalHeader_navi > nav.select > ul");
    // Initially hidden - 初期非表示
    $root.find(".rinnaiglobalHeader_dropDownMenu, .rinnaiGlobalHeader_navi_language, .rinnaiglobalHeader_dropDown_accordion dd").hide();
    $root.find(".rinnaiglobalHeader_dropDown_accordion dt").removeClass("is_active");

    // For multi-level accordion: Expand from current link to parent level - 多段アコーディオン用：カレントリンクから親階層まで展開
    function expandCurrentAccordionDeep($container) {
      if (!$container || !$container.length) return;
      const $curLinks = $container.find(".rinnaiglobalHeader_dropDown_accordion a.is_current");
      if (!$curLinks.length) return;
      $curLinks.each(function () {
        const $a = $(this);
        let $dd = $a.closest("dd");
        // Child, Parent, Grandparent... and so on, expanding all elements by tracing back dd/dt - 子→親→祖父…と dd/dt をさかのぼって全展開
        while ($dd && $dd.length) {
          // Activate dt and expand dd at the same level - 同階層の dt をアクティブ、dd を展開
          const $dt = $dd.prevAll("dt").first();
          if ($dt.length) $dt.addClass("is_active");
          $dd.show();
          // One level up (via the outer <dl> to the parent <dd>) - 1つ上の階層へ（<dd> の外側の <dl> を経由して親 <dd> へ）
          $dd = $dd.closest("dl").closest("dd");
        }
      });
    }

    // Current expansion during loading (mobile): - 読み込み時のカレント展開（SP）：
    // Only expand the section (up to its parent level) and apply is_current if the accordion link matches the current URL - アコーディオン内のリンクが現在URLと一致する場合のみ、is_current付与 & その節（親階層まで）を展開
    // Excludes empty hrefs, hash-only, and javascript/mailto/tel - ※ 空href・ハッシュのみ・javascript/mailto/telは対象外
    (function () {
      const normalize = (p) =>
        String(p || "")
          .replace(/\/index\.html?$/i, "")
          .replace(/\/$/, "");
      const currentPath = normalize(window.location.pathname);
      $root.find(".rinnaiglobalHeader_dropDown_accordion a[href]").each(function () {
        const $a = $(this);
        const rawHref = ($a.attr("href") || "").trim();
        // Exclude invalid links - 無効リンクを除外
        if (!rawHref || rawHref === "#" || rawHref.startsWith("#") || /^javascript:/i.test(rawHref) || /^mailto:/i.test(rawHref) || /^tel:/i.test(rawHref)) return;
        let url;
        try {
          url = new URL(rawHref, window.location.href);
        } catch (_e) {
          return;
        }
        if (url.origin !== window.location.origin) return;
        const aPath = normalize(url.pathname);
        if (!aPath) return;
        if (aPath === currentPath) {
          $a.addClass("is_current");
          const $menu = $a.closest(".rinnaiglobalHeader_dropDownMenu, .rinnaiGlobalHeader_navi_language");
          expandCurrentAccordionDeep($menu); // Pre-expand to parent level - 親階層まで事前展開
        }
      });
    })();

    // Hamburger menu - ハンバーガー
    $root.off("click.sp.hb").on("click.sp.hb", ".js-hamburgerMenuButton", function (e) {
      if (switching) { e.preventDefault(); e.stopPropagation(); return; }
      e.preventDefault();
      e.stopPropagation();
      const $btn = $(this);
      const $li = $btn.closest("li");
      const $menu = $li.find("> .rinnaiglobalHeader_dropDownMenu");
      const expanded = $btn.attr("aria-expanded") === "true";

      if (expanded) {
        $btn.attr("aria-expanded", "false").find(".js-iconLabel").text("Open the menu");
        navCore.close($li, $menu);
        // Disable overlay/scroll lock after closing if no other menus are open - クローズ完了後にオーバーレイ/スクロールロックを解除（他が開いていなければ）
        $menu.one("nav.closed", () => {
          if (!$root.find("> li.is_active").length) {
            navCore._ensureOverlay().hide();
            navCore.unlockBody();
          }
        });
      } else {
        switching = true;
        // Close other open menus and wait for nav.closed before opening - 他の開いているものを閉じ、nav.closed を待ってから開く
        const $others = $root.find('> li.is_active').not($li);
        const openTarget = () => {
          $btn.attr('aria-expanded', 'true').find('.js-iconLabel').text('Close the menu');
          expandCurrentAccordionDeep($menu);
          navCore.lockBody();
          navCore._ensureOverlay().show();
          navCore.open($li, $menu);
          const reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
          if (reduce) {
            switching = false;
          } else {
            $menu.one('transitionend.navOpenDone', () => { switching = false; });
          }
        };
        if (!$others.length) { openTarget(); return; }
        let remaining = 0;
        $others.each(function(){
          const $x = $(this);
          const $m = $x.children('.rinnaiglobalHeader_dropDownMenu, .rinnaiGlobalHeader_navi_language');
          if (!$m.length) return;
          remaining++;
          $m.one('nav.closed', () => { if (--remaining === 0) openTarget(); });
          if (!$x.data('busy') && !$m.data('busy')) navCore.close($x, $m);
        });
      }
    });
    // Language - 言語
    $root.off("click.sp.lang").on("click.sp.lang", ".language_changer_link_sp", function (e) {
      if (switching) { e.preventDefault(); e.stopPropagation(); return; }
      e.preventDefault();
      e.stopPropagation();
      const $li = $(this).closest("li");
      const $menu = $li.find("> .rinnaiGlobalHeader_navi_language");
      if ($li.hasClass("is_active")) {
        navCore.close($li, $menu);
        // Disable overlay/scroll lock as needed after closing - クローズ完了後にオーバーレイ/スクロールロックを必要に応じて解除
        $menu.one("nav.closed", () => {
          if (!$root.find("> li.is_active").length) {
            navCore._ensureOverlay().hide();
            navCore.unlockBody();
          }
        });
      } else {
        switching = true;
        const $others = $root.find('> li.is_active').not($li);
        const openTarget = () => {
          expandCurrentAccordionDeep($menu);
          navCore.lockBody();
          navCore._ensureOverlay().show();
          navCore.open($li, $menu);
          const reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
          if (reduce) {
            switching = false;
          } else {
            $menu.one('transitionend.navOpenDone', () => { switching = false; });
          }
        };
        if (!$others.length) { openTarget(); return; }
        let remaining = 0;
        $others.each(function(){
          const $x = $(this);
          const $m = $x.children('.rinnaiglobalHeader_dropDownMenu, .rinnaiGlobalHeader_navi_language');
          if (!$m.length) return;
          remaining++;
          $m.one('nav.closed', () => { if (--remaining === 0) openTarget(); });
          // if (!$x.data('busy') && !$m.data('busy')) navCore.close($x, $m);
          navCore.close($x, $m); // Excute even busy or opening - ★ busy/opening でも必ず投げる（予約される）
        });
      }
    });

    // Search for mobile - 検索（SP用）
    $root.off("click.sp.search").on("click.sp.search", ".search_link, .search_link_sp", function (e) {
      if (switching) { e.preventDefault(); e.stopPropagation(); return; }
      e.preventDefault();
      e.stopPropagation();
      const $a = $(this);
      const $li = $a.closest("li");
      // Mobile window has a -search menu below li - SPは li 直下に -search メニューがある
      let $menu = $li.children(".rinnaiglobalHeader_dropDownMenu.-search");
      if (!$menu.length) {
        // As a precaution - 念のため next() もフォールバック
        $menu = $a.next(".rinnaiglobalHeader_dropDownMenu.-search");
      }
      if (!$menu.length) return; // As a precaution - 構造不一致安全策

      const expanded = $a.attr("aria-expanded") === "true";
      if (expanded || $li.hasClass("is_active")) {
        $a.attr("aria-expanded", "false");
        navCore.close($li, $menu);
        $menu.one("nav.closed", () => {
          if (!$root.find("> li.is_active").length) {
            navCore._ensureOverlay().hide();
            navCore.unlockBody();
          }
        });
      } else {
        switching = true;
        const $others = $root.find('> li.is_active').not($li);
        const openTarget = () => {
          $a.attr('aria-expanded', 'true');
          expandCurrentAccordionDeep($menu);
          navCore.lockBody();
          navCore._ensureOverlay().show();
          navCore.open($li, $menu);
          const reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
          if (reduce) {
            switching = false;
          } else {
            $menu.one('transitionend.navOpenDone', () => { switching = false; });
          }
        };
        if (!$others.length) { openTarget(); return; }
        let remaining = 0;
        $others.each(function(){
          const $x = $(this);
          const $m = $x.children('.rinnaiglobalHeader_dropDownMenu, .rinnaiGlobalHeader_navi_language');
          if (!$m.length) return;
          remaining++;
          $m.one('nav.closed', () => { if (--remaining === 0) openTarget(); });
          // if (!$x.data('busy') && !$m.data('busy')) navCore.close($x, $m);
          navCore.close($x, $m);
        });
      }
    });

    // Accordion - アコーディオン
    $root.off("click.sp.acd").on("click.sp.acd", ".rinnaiglobalHeader_dropDown_accordion dt", function (e) {
      let acordion_speed = 300;
      e.preventDefault();
      e.stopPropagation();
      const $dt = $(this);
      // Do not process when interactive elements (such as links) are clicked - インタラクティブ要素（リンク等）クリック時は処理しない
      if ($(e.target).closest("a, button, input, label, select, textarea").length) return;
      const $dd = $dt.nextAll("dd").first();
      if ($dt.hasClass("is_active")) {
        $dd.stop(true, true).slideUp(acordion_speed, () => $dt.removeClass("is_active"));
      } else {
        $dt.addClass("is_active");
        $dd.stop(true, true).slideDown(acordion_speed);
      }
    });

    // When the submenu closed (nav.closed), close all accordions - サブメニューが閉じられたら（nav.closed）、アコーディオンをすべて閉じる
    $root.off("nav.closed", ".rinnaiglobalHeader_dropDownMenu, .rinnaiGlobalHeader_navi_language").on("nav.closed", ".rinnaiglobalHeader_dropDownMenu, .rinnaiGlobalHeader_navi_language", function () {
      const $acc = $(this).find(".rinnaiglobalHeader_dropDown_accordion");
      if (!$acc.length) return;
      $acc.find("dt.is_active").removeClass("is_active");
      $acc.find("dd").stop(true, true).slideUp(0);
    });

    // Automatically close menu - メニュー内リンクで自動クローズ
    $root.off("click.sp.link").on("click.sp.link", ".rinnaiglobalHeader_dropDownMenu a, .rinnaiGlobalHeader_navi_language a", function () {
      // Close before screen transition (assumes same-tab link) - 画面遷移前に閉じる（同一タブリンクを想定）
      const $hb = $root.find('.js-hamburgerMenuButton[aria-expanded="true"]');
      if ($hb.length) {
        $hb.attr("aria-expanded", "false").find(".js-iconLabel").text("Open the menu");
      }
      $root.find("> li.is_active").each(function () {
        const $x = $(this),
          $m = $x.children(".rinnaiglobalHeader_dropDownMenu, .rinnaiGlobalHeader_navi_language");
        navCore.close($x, $m);
      });
      navCore._ensureOverlay().hide();
      navCore.unlockBody();
    });

    // Close with Overlay Tap (mobile) - オーバーレイタップでクローズ（SP）
    navCore
      ._ensureOverlay()
      .off("click.sp")
      .on("click.sp", function (e) {
        e.preventDefault();
        e.stopPropagation();
        const $ov = $(this);

        // Get the currently open top-level <li> - いま開いているトップレベル <li> を取得
        const $targets = $root.find("> li.is_active");
        if (!$targets.length) {
          $ov.hide();
          navCore.unlockBody();
          return;
        }

        // Reset toggle state - トグル状態をリセット
        $root.find('.js-hamburgerMenuButton[aria-expanded="true"]').attr("aria-expanded", "false").find(".js-iconLabel").text("メニューを開く");
        $root.find('.search_link[aria-expanded="true"], .search_link_sp[aria-expanded="true"]').attr("aria-expanded", "false");

        // Close all open submenus and remove the overlay/scroll bar upon completion - すべての開いているサブメニューをクローズし、完了後にオーバーレイ/スクロール解除
        let remaining = 0;
        const $activeLis = $root.find("> li.is_active"); // Confirm first - 先に確定
        $activeLis.each(function () {
          const $li = $(this);
          const $menu = $li.children(".rinnaiglobalHeader_dropDownMenu, .rinnaiGlobalHeader_navi_language");
          if ($menu.length) {
            remaining++;
            $menu.one("nav.closed", () => {
              if (--remaining === 0) {
                $ov.hide();
                navCore.unlockBody();
              }
            });
            navCore.close($li, $menu);
          }
        });

        if (remaining === 0) {
          $ov.hide();
          navCore.unlockBody();
        }
      });

    // Close button (mobile) in the submenu - サブメニュー内の閉じるボタン（SP）
    $root.off("click.sp.close").on("click.sp.close", ".menu_close, .search_close", function (e) {
      e.preventDefault();
      e.stopPropagation();
      const $li = $(this).closest("li");
      const $menu = $li.children(".rinnaiglobalHeader_dropDownMenu, .rinnaiGlobalHeader_navi_language");
      if (!$menu.length) return;
      // Reset toggle state - トグルの状態もリセット
      const $hb = $li.find('.js-hamburgerMenuButton[aria-expanded="true"]');
      if ($hb.length) {
        $hb.attr("aria-expanded", "false").find(".js-iconLabel").text("Open the menu");
      }
      const $searchToggler = $li.find('.search_link[aria-expanded="true"], .search_link_sp[aria-expanded="true"]');
      if ($searchToggler.length) {
        $searchToggler.attr("aria-expanded", "false");
      }
      navCore.close($li, $menu);
      $menu.one("nav.closed", () => {
        if (!$root.find("> li.is_active").length) {
          navCore._ensureOverlay().hide();
          navCore.unlockBody();
        }
      });
    });
  }
  function destroy() {
    if (!$root) return;
    $root.off("click.sp.hb click.sp.lang click.sp.acd click.sp.link click.sp.search click.sp.close");
    navCore._ensureOverlay().off("click.sp");
    $root.find("> li.is_active").removeClass("is_active").children(".rinnaiglobalHeader_dropDownMenu, .rinnaiGlobalHeader_navi_language").hide();
    navCore._ensureOverlay().hide();
    navCore.unlockBody();
  }
  return { init, destroy };
})();

// Controller - コントローラ（既存のまま利用）
const NavController = (() => {
  let current = null;
  const mql = window.matchMedia("(min-width:1245px)");
  const map = { pc: GlobalNavPC, sp: GlobalNavSP };
  function apply() {
    const mode = mql.matches ? "pc" : "sp";
    if (mode === current) return;
    if (current) map[current].destroy();
    map[mode].init();
    current = mode;
  }
  mql.addEventListener("change", () => setTimeout(apply, 150));
  return { init: apply };
})();

// Customer type (Entrance) Navigation Module - エントランスナビ用モジュール
const EntranceNav = (function () {
  function init(selector) {
    const currentPath = window.location.pathname.replace(/\/$/, "");
    // Compare with each link and set is_active - 各リンクと比較し is_active を付与
    $(`${selector} li a`).each(function () {
      let href = $(this).attr("href").replace(/\/$/, "");
      if (href === currentPath) {
        $(this).parent("li").addClass("is_active");
      }
    });
  }

  return { init };
})();
