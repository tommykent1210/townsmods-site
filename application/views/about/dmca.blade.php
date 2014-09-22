@layout('template')

@section('title')
About DMCA
@endsection

@section('content')
  <div class="well">
    <legend>About DMCA</legend>

    <p>As a content provider, one that provides a service allowing the public to upload content, 
      we are committed to ensuring that all content is posted from users that hold appropriate copyrights 
      to the work. For that reason, we have a semi-automated system in place. 
    </p>

    <legend>Filing a DMCA claim</legend>
    <p>
      To file a DMCA claim you have two options:
    </p>

    <h4>Option 1: Direct Reporting</h4>
    <p>
      The first method for having content removed is by clicking the <a class="btn btn-danger btn-mini"><i class="icon-warning-sign"></i> Report</a> 
      button and selecting "Report Copyright Infringement". Note: this requires you to be logged in as an email verified user. 
      Whilst we admit, this isn't ideal. This allows us to reduce the number of fraudulent DMCA claims.
    </p>
    <p>
      From there, you will be asked to fill out some details in roder to verify you own the content and it was posted without
      permission. The best way to do this is to give a verifiable link to a website (such as the towns forums) where we can see 
      the original date and username of the user who posted the content. We will likely contact you there for verification.
    </p>

    <br />
    <h4>Option 2: Email Reporting</h4>
    <p>
      If you wish to file a DMCA claim via email we have the facilities to accommodate that. Simply send an email to: <strong>dmca@townsmods.net</strong> with the 
      subject being:
      <pre>DMCA CLAIM: {MOD ID}</pre>
      Replace the {MOD ID} with the ID of the mod you wish to report (you can find this at the end of the URL on the project page).
      In the body of your message, please give details about your ownership of the content.
    </p>
    <div class="alert alert-error">
      <strong>Warning:</strong> We take all DMCA claims seriously, but claims made fraudulently, will result in them being discarded and your account/email 
      may be banned form filing any further claims. Similarly, any email claims that do not display a properly formatted subject line will be automatically discarded.
    </div>

    <legend>Where to go from there</legend>

    <p>
      From there, somebody will review your DMCA claim. If we require more verification, we will message you. 
      If we need to verify your ownership we will attempt to contact who we believe to be the original author. 
      However, if we determine that you are not the original author, the claim will be rejected.
      If we verify your claim, the offending content will be removed from our servers, and appropriate action will be taken
      against the uploader.
    </p>
  </div>


@endsection