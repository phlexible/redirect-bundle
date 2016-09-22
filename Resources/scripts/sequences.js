Ext.require('Phlexible.element.ElementAccordion');

Phlexible.element.ElementAccordion.prototype.populateItems = Phlexible.element.ElementAccordion.prototype.populateItems.createSequence(function() {
    if (Phlexible.User.isGranted('ROLE_ELEMENT_REDIRECT')) {
        this.items.push({
            xtype: 'elementredirect-redirectaccordion',
            collapsed: true
        });
    }
});
