AccountsTemplates.configure({
    forbidClientAccountCreation: false,
});

var pwd = AccountsTemplates.removeField('password');
AccountsTemplates.addFields([
  {
      _id: "username",
      type: "text",
      displayName: "username",
      required: true,
      minLength: 5,
  },
  pwd
]);

AccountsTemplates.configure({                                       
    showAddRemoveServices: true,                                                         
    showForgotPasswordLink: true,                                  
    showLabels: true,                                                               
    showPlaceholders: true,                                                                 
    // Behaviour                                           
    confirmPassword: true,                                       
    defaultState: "signIn",                                                       
    enablePasswordChange: true,                                                                  
    forbidClientAccountCreation: true,                                                             
    overrideLoginErrors: true,                                                                    
    sendVerificationEmail: true,                                                  
});