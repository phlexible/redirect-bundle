Ext.provide('Phlexible.elementredirect.RedirectAccordion');

Phlexible.elementredirect.RedirectAccordion = Ext.extend(Ext.grid.EditorGridPanel, {
    strings: Phlexible.elementredirect.Strings,
    title: Phlexible.elementredirect.Strings.redirects,
    iconCls: 'p-elementredirect-component-icon',
    cls: 'p-elements-redirects-accordion',
    border: false,
    autoHeight: true,
    autoExpandColumn: 'url',
    viewConfig: {
        emptyText: Phlexible.elementredirect.Strings.no_redirects_defined
    },

    key: 'redirect',

    initComponent: function() {
        this.store = new Ext.data.SimpleStore({
            fields: ['url'],
            listeners: {
                datachanged: {
                    fn: function(store) {
                        this.updateTitle(store.getCount());
                    },
                    scope: this
                }
            }
        });

        this.columns = [{
            id: 'url',
            header: this.strings.url,
            dataIndex: 'url',
            editor: new Ext.form.TextField()
        }];

        this.sm = new Ext.grid.RowSelectionModel({
            multiSelect: true,
            listeners: {
                selectionchange: {
                    fn: function(sm) {
                        var records = sm.getSelections();

                        if (!records.length) {
                            this.getTopToolbar().items.items[2].disable();
                        }
                        else {
                            this.getTopToolbar().items.items[2].enable();
                        }
                    },
                    scope: this
                }
            }
        });

        this.tbar = [{
            text: this.strings.add,
            iconCls: 'm-redirects-add-icon',
            handler: function() {
                var r = new Ext.data.Record({url: ''});
                this.store.insert(0, r);
            },
            scope: this
        },'-',{
            text: this.strings['remove'],
            iconCls: 'm-redirects-remove-icon',
            handler: function() {
                var records = this.getSelectionModel().getSelections();

                Ext.each(records, function(r) {
                    this.store.remove(r);
                }, this);
            },
            scope: this
        }];

        Makeweb.redirects.RedirectAccordion.superclass.initComponent.call(this);
    },

    load: function(data) {
        if(data.properties.et_type != 'full') {
            this.updateTitle();
            this.hide();
            return;
        }

        this.updateTitle(data.redirects.length);
        this.store.loadData(data.redirects);

        this.show();
    },

    getData: function() {
        var data = [];

        var records = this.store.getRange();

        for(var i=0; i<records.length; i++) {
            data.push(records[i].data.url);
        }

        return data;
    },

    updateTitle: function(count) {
        if (!count) {
            this.setTitle(this.strings.redirects);
        }
        else {
            this.setTitle(this.strings.redirects + ' [' + count + ']');
        }
    }
});

Ext.reg('elementredirect-redirectaccordion', Phlexible.elementredirect.RedirectAccordion);
