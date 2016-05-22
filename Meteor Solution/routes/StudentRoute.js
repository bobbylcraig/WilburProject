Router.route("/budgets", {
  action: function () {
      this.render("budgetDashboard");
  },
  onAfterAction: function () {
    if (!Meteor.isClient) {
      return;
    }
    SEO.set({title: Meteor.App.NAME});
  }
});

Router.route("/budgets/:_id", {
  name: "budgetDashboard",
  data: function () {
    return Budgets.findOne({_id: this.params._id});
  },
  action: function () {
    this.render();
  },
  onAfterAction: function () {
    if (!Meteor.isClient) {
      return;
    }
    var budget = this.data();
    if (budget) {
      SEO.set({title: budget.title + " - " + Meteor.App.NAME});
    }
  }
});