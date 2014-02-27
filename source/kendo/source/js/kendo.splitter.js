(function($, undefined) {
    /**
    * @name kendo.ui.Splitter.Description
    *
    * @section
    *   <p>
    *       The Splitter widget provides an easy way to create a dynamic layout of resizable and
    *       collapsible panes. The widget converts the children of an HTML element in to the interactive
    *       layout, adding resize and collapse handles based on configuration. Splitters can be mixed
    *       in both vertical and horizontal orientations to build complex layouts.
    *   </p>
    *   <h3>Getting Started</h3>
    *
    * @exampleTitle Create a root HTML div element with children that will become panes
    * @example
    * <div id="splitter">
    *    <div>
    *        Area 1
    *    </div>
    *    <div>
    *        Area 2
    *    </div>
    * </div>
    *
    * @exampleTitle Initialize the Splitter using a jQuery selector
    * @example
    *   $("#splitter").kendoSplitter();
    * @section
    *   <p>
    *       When the Splitter is initialized, a vertical split bar will be placed between the two
    *       HTML divs. This bar can be moved by a user left and right to adjust the size on the panes.
    *   </p>
    *   <h3>Configuring Splitter Behavior</h3>
    *   <p>
    *       Splitter provides many configuration options that can be easily set during initialization.
    *       Among the properties that can be controlled:
    *   </p>
    *   <ul>
    *       <li>Min/Max pane size</li>
    *       <li>Resizable and Collapsible pane behaviors</li>
    *       <li>Orientation of the splitter</li>
    *   </ul>
    *   <p>
    *       Pane properties are set for each individual pane in a Splitter, whereas Splitter properties apply to the entire widget.
    *   </p>
    * @exampleTitle Setting Splitter and Pane properties
    * @example
    *   $("#splitter").kendoSplitter({
    *       panes: [{
    *           min: "100px",
    *           max: "300px",
    *           collapsible: true
    *       },
    *       {
    *           collapsible: true
    *       }],
    *       orientation: "vertical"
    *   });
    * @section
    *   <h3>Nested Splitter Layouts</h3>
    *   <p>
    *       To achieve complex layouts, it may be necessary to nest Splitters in different orientations.
    *       Splitter fully supports nested configurations. All that is required is proper HTML
    *       configuration and multiple Kendo Splitter initializations.
    *   </p>
    * @exampleTitle Creating nested Splitter layout
    * @example
    *   <!-- Define nested HTML layout with divs-->
    *   <div id="horizontalSplitter">
    *       <div><p>Left Side Pane Content</p></div>
    *       <div>
    *           <div id="verticalSplitter">
    *               <div><p>Right Side, Top Pane Content</p></div>
    *               <div><p>Right Side, Bottom Pane Content</p></div>
    *           </div>
    *       </div>
    *   </div>
    * @exampleTitle
    * @example
    *   //Initialize both Splitters with the proper orientation
    *   $(document).ready(function(){
    *       $("horizontalSplitter").kendoSplitter();
    *       $("verticalSplitter").kendoSplitter({orientation: "vertical"});
    *   });
    *
    * @section
    *   <h3>Loading Content with Ajax</h3>
    *   <p>
    *       While any valid technique for loading Ajax content can be used, Splitter provides built-in
    *       support for asynchronously loading content from URLs. These URLs should return HTML fragments
    *       that can be loaded in a Splitter pane. Ajax content loading must be configured for each Pane that should use it.
    *   </p>
    * @exampleTitle Loading Splitter content asynchronously
    * @example
    *   <!-- Define the Splitter HTML-->
    *   <div id="splitter">
    *       <div>Area 1 with Static Content</div>
    *       <div> </div>
    *   </div>
    * @exampleTitle
    * @example
    *   //Initialize the Splitter and configure async loading for one pane
    *   $(document).ready(function(){
    *       $("#splitter").kendoSplitter({
    *           panes: [null,{ contentUrl: "html-content-snippet.html"}]
    *       });
    *   });
    */
    var kendo = window.kendo,
        ui = kendo.ui,
        extend = $.extend,
        proxy = $.proxy,
        Component = ui.Component,
        pxUnitsRegex = /^\d+px$/i,
        percentageUnitsRegex = /^\d+(\.\d+)?%$/i,
        EXPAND = "expand",
        COLLAPSE = "collapse",
        CONTENTLOAD = "contentLoad",
        RESIZE = "resize",
        HORIZONTAL = "horizontal",
        VERTICAL = "vertical",
        MOUSEENTER = "mouseenter",
        CLICK = "click",
        PANE = "pane",
        MOUSELEAVE = "mouseleave";

    function isPercentageSize(size) {
        return percentageUnitsRegex.test(size);
    }

    function isPixelSize(size) {
        return pxUnitsRegex.test(size);
    }

    function isFluid(size) {
        return !isPercentageSize(size) && !isPixelSize(size);
    }

    function panePropertyAccessor(propertyName, triggersResize) {
        return function(pane, value) {
            var paneConfig = $(pane).data(PANE);

            if (arguments.length == 1) {
                return paneConfig[propertyName];
            }

            paneConfig[propertyName] = value;

            if (triggersResize) {
                var splitter = this.element.data("kendoSplitter");
                splitter.trigger(RESIZE);
            }
        };
    }

    var Splitter = Component.extend(/** @lends kendo.ui.Splitter.prototype */ {
        /**
         * Creates a Splitter instance.
         * @constructs
         * @extends kendo.ui.Component
         * @param {DomElement} element DOM element
         * @param {Object} options Configuration options.
         * @option {String} [orientation] <horizontal> Specifies the orientation of the splitter.
         *    <dl>
         *         <dt>
         *              "horizontal"
         *         </dt>
         *         <dd>
         *              Define horizontal orientation of the splitter.
         *         </dd>
         *         <dt>
         *              "vertical"
         *         </dt>
         *         <dd>
         *              Define vertical orientation of the splitter.
         *         </dd>
         *    </dl>
         * @option {Array} [panes] Array of pane definitions.
         * _example
         *  $("#splitter").kendoSplitter({
         *      //definitions for the first three panes
         *      panes: [
         *          {
         *              size: "200px",
         *              min: "100px",
         *              max: "300px"
         *          },
         *          {
         *              size: "20%",
         *              resizable: false
         *         },
         *         {
         *              collapsed: true,
         *              collapsible: true
         *         }
         *      ]
         *   });
         * @option {String} [panes.size] Specifies the size of the pane.
         * <p>
         * The size can be defined in pixes or in percents.
         * </p>
         * <p>
         * The size cannot be more than panes.max and less then panes.min.
         * </p>
         * @option {String} [panes.min] Specifies the minimum size of the pane.
         * <p>
         * Resized pane cannot be smaller then the defined minimum size.
         * </p>
         * @option {String} [panes.max] Specifies the maximum size of the pane.
         * <p>
         * Resized pane cannot be bigger then the defined maximum size.
         * </p>
         * @option {Boolean} [panes.collapsed] <false> Specifies whether the pane is initially collapsed.
         * @option {Boolean} [panes.collapsible] <false> Specifies whether the pane can be collapsed by the user.
         * @option {Boolean} [panes.scrollable] <true> Specifies whether the pane shows a scrollbar when its content overflows.
         * @option {Boolean} [panes.resizable] <true> Specifies whether the pane can be resized by the user.
         * @option {Boolean} [panes.contentUrl] <true> Specifies URL from which to load the pane content.
         */
        init: function(element, options) {
            var that = this,
                panesConfig,
                splitbarSelector,
                expandCollapseSelector = ".k-splitbar .k-icon:not(.k-resize-handle)",
                triggerResize = function() {
                    that.trigger(RESIZE);
                };

            Component.fn.init.call(that, element, options);

            that.orientation = that.options.orientation.toLowerCase() != VERTICAL ? HORIZONTAL : VERTICAL;
            splitbarSelector = ".k-splitbar-draggable-" + that.orientation;

            that.bind([
                /**
                 * Fires before a pane is expanded.
                 * @name kendo.ui.Splitter#expand
                 * @event
                 * @param {Event} e
                 * @param {Element} e.pane The expanding pane
                 */
                EXPAND,
                /**
                 * Fires before a pane is collapsed.
                 * @name kendo.ui.Splitter#collapse
                 * @event
                 * @param {Event} e
                 * @param {Element} e.pane The collapsing pane
                 */
                COLLAPSE,
                /**
                 * Fires when a request for the pane contents has finished
                 * @name kendo.ui.Splitter#contentLoad
                 * @event
                 * @param {Event} e
                 * @param {Element} e.pane The pane whose content has been loaded.
                 */
                CONTENTLOAD,
                /**
                 * Fires when a pane is resized
                 * @name kendo.ui.Splitter#resize
                 * @event
                 * @param {Event} e
                 * @param {Element} e.pane The pane which is resized
                 */
                RESIZE
            ], that.options);

            that.bind(RESIZE, proxy(that._resize, that));

            that._initPanes();

            that.element
                .delegate(splitbarSelector, MOUSEENTER, function() { $(this).addClass("k-splitbar-" + that.orientation + "-hover"); })
                .delegate(splitbarSelector, MOUSELEAVE, function() { $(this).removeClass("k-splitbar-" + that.orientation + "-hover"); })
                .delegate(expandCollapseSelector, MOUSEENTER, function() { $(this).addClass("k-state-hover")})
                .delegate(expandCollapseSelector, MOUSELEAVE, function() { $(this).removeClass('k-state-hover')})
                .delegate(".k-splitbar .k-collapse-next, .k-splitbar .k-collapse-prev", CLICK, that._arrowClick(COLLAPSE))
                .delegate(".k-splitbar .k-expand-next, .k-splitbar .k-expand-prev", CLICK, that._arrowClick(EXPAND))
                .delegate(".k-splitbar", "dblclick", proxy(that._dbclick, that))
                .parent().closest(".k-splitter").each(function() {
                    $(this).data("kendoSplitter").bind(RESIZE, triggerResize);
                });

            $(window).resize(triggerResize);

            that.resizing = new PaneResizing(that);
        },

        options: {
            orientation: HORIZONTAL
        },

        _initPanes: function() {
            var that = this,
                panesConfig = that.options.panes || [];

            that.element
                .addClass("k-widget").addClass("k-splitter")
                .children()
                    .addClass("k-pane")
                    .each(function (index, pane) {
                        var config = panesConfig && panesConfig[index];

                        pane = $(pane);

                        pane.data(PANE, config ? config : {})
                            .toggleClass("k-scrollable", config ? config.scrollable !== false : true);
                        that.ajaxRequest(pane);
                    })
                .end();
            that.trigger(RESIZE);
        },

        /**
        * Loads the pane content from the specified URL.
        * @param {Selector|DomElement|jQueryObject} pane The pane whose content
        * @param {String} url The URL which returns the pane content.
        * @param {Object|String} data Data to be sent to the server.
        * @example
        * splitter.ajaxRequest("#Pane1", "/customer/profile", { id: 42 });
        */
        ajaxRequest: function(pane, url, data) {
            pane = $(pane);

            var that = this,
                paneConfig = pane.data(PANE);

            url = url || paneConfig.contentUrl;

            if (url) {
                pane.append("<span class='k-icon k-loading k-pane-loading' />");

                $.ajax({
                    url: url,
                    data: data || {},
                    type: "GET",
                    dataType: "html",
                    success: function (data) {
                        pane.html(data);

                        that.trigger(CONTENTLOAD, { pane: pane[0] });
                    }
                });
            }
        },
        _triggerAction: function(type, pane) {
            if (!this.trigger(type, { pane: pane[0] })) {
                this[type](pane[0]);
            }
        },
        _dbclick: function(e) {
            var that = this,
                target = $(e.target),
                arrow;

            if (target.closest(".k-splitter")[0] != that.element[0]) {
                return;
            }

            arrow = target.children(".k-icon:not(.k-resize-handle)");

            if (arrow.length !== 1) {
                return;
            }

            if (arrow.is(".k-collapse-prev")) {
                that._triggerAction(COLLAPSE, target.prev());
            } else if (arrow.is(".k-collapse-next")) {
                that._triggerAction(COLLAPSE, target.next());
            } else if (arrow.is(".k-expand-prev")) {
                that._triggerAction(EXPAND, target.prev());
            } else if (arrow.is(".k-expand-next")) {
                that._triggerAction(EXPAND, target.next());
            }
        },
        _arrowClick: function (arrowType) {
            var that = this;

            return function(e) {
                var target = $(e.target),
                    pane;

                if (target.closest(".k-splitter")[0] != that.element[0])
                    return;

                if (target.is(".k-" + arrowType + "-prev")) {
                    pane = target.parent().prev();
                } else {
                    pane = target.parent().next();
                }
                that._triggerAction(arrowType, pane);
            };
        },
        _appendSplitBars: function(panes) {
            var splitBarsCount = panes.length - 1,
                pane,
                previousPane,
                nextPane,
                idx,
                isSplitBarDraggable,
                catIconIf = function(iconType, condition) {
                   return condition ? "<div class='k-icon " + iconType + "' />" : "";
                };

            for (idx = 0; idx < splitBarsCount; idx++) {
                pane = panes.eq(idx);
                previousPane = pane.data(PANE);
                nextPane = pane.next().data(PANE);

                if (!nextPane) {
                    continue;
                }

                isSplitBarDraggable = (previousPane.resizable !== false) && (nextPane.resizable !== false);

                pane.after("<div class='k-splitbar k-state-default k-splitbar-" + this.orientation +
                        (isSplitBarDraggable && !previousPane.collapsed && !nextPane.collapsed ?  " k-splitbar-draggable-" + this.orientation : "") +
                    "'>" + catIconIf("k-collapse-prev", previousPane.collapsible && !previousPane.collapsed) +
                    catIconIf("k-expand-prev", previousPane.collapsible && previousPane.collapsed) +
                    catIconIf("k-resize-handle", isSplitBarDraggable) +
                    catIconIf("k-collapse-next", nextPane.collapsible && !nextPane.collapsed) +
                    catIconIf("k-expand-next", nextPane.collapsible && nextPane.collapsed) + "</div>");
            }
        },
        _resize: function() {
            var that = this,
                element = that.element,
                panes = element.children(":not(.k-splitbar)"),
                isHorizontal = that.orientation == HORIZONTAL,
                splitBars = element.children(".k-splitbar"),
                splitBarsCount = splitBars.length,
                sizingProperty = isHorizontal ? "width" : "height",
                totalSize = element[sizingProperty]();

            if (splitBarsCount === 0) {
                splitBarsCount = panes.length - 1;
                that._appendSplitBars(panes);
                splitBars = element.children(".k-splitbar");
            }

            // discard splitbar sizes from total size
            splitBars.each(function() {
                totalSize -= this[isHorizontal ? "offsetWidth" : "offsetHeight"];
            });

            var sizedPanesWidth = 0,
                sizedPanesCount = 0,
                freeSizedPanes = $();

            panes.css({ position: "absolute", top: 0 })
                [sizingProperty](function() {
                    var config = $(this).data(PANE) || {}, size;

                    if (config.collapsed) {
                        size = 0;
                    } else if (isFluid(config.size)) {
                        freeSizedPanes = freeSizedPanes.add(this);
                        return;
                    } else { // sized in px/%, not collapsed
                        size = parseInt(config.size, 10);

                        if (isPercentageSize(config.size)) {
                            size = Math.floor(size * totalSize / 100);
                        }
                    }

                    sizedPanesCount++;
                    sizedPanesWidth += size;

                    return size;
                });

            totalSize -= sizedPanesWidth;

            var freeSizePanesCount = freeSizedPanes.length,
                freeSizePaneWidth = Math.floor(totalSize / freeSizePanesCount);

            freeSizedPanes
                .slice(0, freeSizePanesCount - 1).css(sizingProperty, freeSizePaneWidth).end()
                .eq(freeSizePanesCount - 1).css(sizingProperty, totalSize - (freeSizePanesCount - 1) * freeSizePaneWidth);

            // arrange panes
            var sum = 0,
                alternateSizingProperty = isHorizontal ? "height" : "width",
                positioningProperty = isHorizontal ? "left" : "top",
                sizingDomProperty = isHorizontal ? "offsetWidth" : "offsetHeight";

            element.children()
                .css(alternateSizingProperty, element[alternateSizingProperty]())
                .each(function (i, child) {
                    child.style[positioningProperty] = Math.floor(sum) + "px";
                    sum += child[sizingDomProperty];
                });
        },
        toggle: function(pane, expand) {
            var pane = $(pane),
                previousSplitBar = pane.prev(".k-splitbar"),
                nextSplitBar = pane.next(".k-splitbar"),
                splitbars = previousSplitBar.add(nextSplitBar),
                paneConfig = pane.data(PANE),
                prevPaneConfig = pane.prevAll(".k-pane:first").data(PANE),
                nextPaneConfig = pane.nextAll(".k-pane:first").data(PANE),
                orentation = this.orientation,
                hoverClass = "k-splitbar-" + orentation + "-hover",
                draggableClass = "k-splitbar-draggable-" + orentation;

            if (arguments.length == 1) {
                expand = paneConfig.collapsed === undefined ? false : paneConfig.collapsed;
            }

            previousSplitBar
                .toggleClass(draggableClass, expand && paneConfig.resizable !== false && (!prevPaneConfig || prevPaneConfig.resizable !== false))
                .removeClass(hoverClass)
                .find(expand ? ".k-expand-next" : ".k-collapse-next")
                    .toggleClass("k-expand-next", !expand)
                    .toggleClass("k-collapse-next", expand);

            nextSplitBar
                .toggleClass(draggableClass, expand && paneConfig.resizable !== false && (!nextPaneConfig || nextPaneConfig.resizable !== false))
                .removeClass(hoverClass)
                .find(expand ? ".k-expand-prev" : ".k-collapse-prev")
                    .toggleClass("k-expand-prev", !expand)
                    .toggleClass("k-collapse-prev", expand);

            paneConfig.collapsed = !expand;

            this.trigger(RESIZE);
        },
        /**
        * Collapses the specified Pane item
        * @param {Selector|DomElement|jQueryObject} pane The pane, which will be collapsed.
        * @example
        * splitter.collapse("#Item1"); //id of the first pane
        */
        collapse: function(pane) {
            this.toggle(pane, false);
        },
        /**
        * Expands the specified Pane item
        * @param {Selector|DomElement|jQueryObject} pane The pane, which will be expanded.
        * @example
        * splitter.expand("#Item1"); //id of the first pane
        */
        expand: function(pane) {
            this.toggle(pane, true);
        },
        /**
        * Set the size of the pane.
        * @name kendo.ui.Splitter#size
        * @function
        * @param {Selector|DomElement|jQueryObject} pane The pane
        * @param {String} value The new size of the pane.
        * @example
        * splitter.size("#Item1", "200px");
        */
        size: panePropertyAccessor("size", true),
        /**
        * Set the minimum size of the pane.
        * @name kendo.ui.Splitter#min
        * @function
        * @param {Selector|DomElement|jQueryObject} pane The pane
        * @param {String} value The minimum size value.
        * @example
        * splitter.min("#Item1", "100px");
        */
        min: panePropertyAccessor("min"),
        /**
        * Set the maximum size of the pane.
        * @name kendo.ui.Splitter#max
        * @function
        * @param {Selector|DomElement|jQueryObject} pane The pane
        * @param {String} value The maximum size value.
        * @example
        * splitter.max("#Item1", "300px");
        */
        max: panePropertyAccessor("max")
    });

    ui.plugin("Splitter", Splitter);

    var verticalDefaults = {
            sizingProperty: "height",
            sizingDomProperty: "offsetHeight",
            alternateSizingProperty: "width",
            positioningProperty: "top",
            mousePositioningProperty: "pageY"
        };

    var horizontalDefaults = {
            sizingProperty: "width",
            sizingDomProperty: "offsetWidth",
            alternateSizingProperty: "height",
            positioningProperty: "left",
            mousePositioningProperty: "pageX"
        };

    function PaneResizing(splitter) {
        var that = this;

        that.owner = splitter;
        that._element = that.owner.element;
        that.orientation = that.owner.orientation;

        extend(that, that.orientation === HORIZONTAL ? horizontalDefaults : verticalDefaults);

        that._resizable = new kendo.ui.Resizable(splitter.element, {
            orientation: that.orientation,
            handle: that.orientation == HORIZONTAL ? ".k-splitbar-draggable-horizontal" : ".k-splitbar-draggable-vertical",
            hint: proxy(that._createHint, that),
            start: proxy(that._start, that),
            max: proxy(that._max, that),
            min: proxy(that._min, that),
            invalidClass:"k-restricted-size-" + that.orientation,
            resizeend: proxy(that._stop, that)
        });
    }

    PaneResizing.prototype = {
        _createHint: function(handle) {
            var that = this;
            return $("<div class='k-ghost-splitbar k-ghost-splitbar-" + that.orientation + " k-state-default' />")
                        .css(that.alternateSizingProperty, handle[that.alternateSizingProperty]())
        },
        _start: function(e) {
            var that = this,
                splitBar = $(e.currentTarget),
                previousPane = splitBar.prev(),
                nextPane = splitBar.next(),
                previousPaneConfig = previousPane.data(PANE),
                nextPaneConfig = nextPane.data(PANE),
                prevBoundary = parseInt(previousPane[0].style[that.positioningProperty]),
                nextBoundary = parseInt(nextPane[0].style[that.positioningProperty]) + nextPane[0][that.sizingDomProperty] - splitBar[0][that.sizingDomProperty],
                totalSize = that._element.css(that.sizingProperty),
                toPx = function (value) {
                    var val = parseInt(value, 10);
                    return (isPixelSize(value) ? val : (totalSize * val) / 100) || 0;
                },
                prevMinSize = toPx(previousPaneConfig.min),
                prevMaxSize = toPx(previousPaneConfig.max) || nextBoundary - prevBoundary,
                nextMinSize = toPx(nextPaneConfig.min),
                nextMaxSize = toPx(nextPaneConfig.max) || nextBoundary - prevBoundary;

            that.previousPane = previousPane;
            that.nextPane = nextPane;
            that._maxPosition = Math.min(nextBoundary - nextMinSize, prevBoundary + prevMaxSize);
            that._minPosition = Math.max(prevBoundary + prevMinSize, nextBoundary - nextMaxSize);
        },
        _max: function(e) {
              return this._maxPosition;
        },
        _min: function(e) {
            return this._minPosition;
        },
        _stop: function(e) {
            var that = this;

            if (e.keyCode !== kendo.keys.ESC) {
                var ghostPosition = e.position,
                    splitBar = $(e.currentTarget),
                    previousPane = splitBar.prev(),
                    nextPane = splitBar.next(),
                    previousPaneConfig = previousPane.data(PANE),
                    nextPaneConfig = nextPane.data(PANE),
                    previousPaneNewSize = ghostPosition - parseInt(previousPane[0].style[that.positioningProperty]),
                    nextPaneNewSize = parseInt(nextPane[0].style[that.positioningProperty]) + nextPane[0][that.sizingDomProperty] - ghostPosition - splitBar[0][that.sizingDomProperty],
                    fluidPanesCount = that._element.children(".k-pane").filter(function() { return isFluid($(this).data(PANE).size); }).length;

                if (!isFluid(previousPaneConfig.size) || fluidPanesCount > 1) {
                    if (isFluid(previousPaneConfig.size)) {
                        fluidPanesCount--;
                    }

                    previousPaneConfig.size = previousPaneNewSize + "px";
                }

                if (!isFluid(nextPaneConfig.size) || fluidPanesCount > 1) {
                    nextPaneConfig.size = nextPaneNewSize + "px";
                }

                that.owner.trigger(RESIZE);
            }

            return false;
        }
    }

})(jQuery);
