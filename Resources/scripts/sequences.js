Ext.require('Phlexible.elementredirect.RedirectAccordion');
Ext.require('Phlexible.elements.ElementAccordion');

Phlexible.elements.ElementAccordion.prototype.populateItems = Phlexible.elements.ElementAccordion.prototype.populateItems.createSequence(function() {
    if (Phlexible.User.isGranted('ROLE_ELEMENT_REDIRECT')) {
        this.items.push({
            xtype: 'elementredirect-redirectaccordion',
            collapsed: true
        });
    }
});
