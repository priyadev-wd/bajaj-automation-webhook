<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clover Connection</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal"><img alt="Clover logo" src="{{ asset('images/clover_logo.png') }}" width="250"/></h5>
    </div>
</div>

  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <form>
          <div class="mb-3">
            <label for="cloudAppId" class="form-label">Application ID</label>
            <input type="text" class="form-control" id="cloudAppId" aria-describedby="cloudAppIdHelp" required>
            <div id="cloudAppIdHelp" class="form-text">
              The <a href="https://docs.clover.com/clover-platform/docs/create-your-remote-app-id" target="_blank">remote application ID (RAID)</a> of the POS app.
            </div>
          </div>

          <div class="mb-3">
            <label for="accessToken" class="form-label">Access Token</label>
            <input type="text" class="form-control" id="accessToken" aria-describedby="accessTokenHelp" required>
            <div id="accessTokenHelp" class="form-text">
                The OAuth token used when contacting the Clover server.
                The steps for obtaining the token are available <a href="https://docs.clover.com/clover-platform/docs/using-oauth-20" target="_blank">on the Using OAuth 2.0 page</a>.
            </div>
          </div>

          <div class="mb-3">
            <label for="refreshToken" class="form-label">Refresh Token</label>
            <input type="text" class="form-control" id="refreshToken" aria-describedby="refreshTokenHelp" required>
            <div id="refreshTokenHelp" class="form-text">
              A one-time-use token that is used to generate another access token when it expires. Refresh tokens expire, but they are valid for a longer period of time than the access token
            </div>
          </div>


          <div class="mb-3">
            <label for="merchantId" class="form-label">Merchant ID</label>
            <input type="text" class="form-control" id="merchantId" aria-describedby="merchantIdHelp" required>
            <div id="merchantIdHelp" class="form-text"> The steps for finding your merchantId are available
              <a href="https://docs.clover.com/clover-platform/docs/merchant-id-and-api-token-for-development" target="_blank">on the Test Merchant IDs & API Tokens page</a>.
            </div>
          </div>


          <div class="mb-3">
            <label for="clientSecret" class="form-label">Client Secret</label>
            <input type="text" class="form-control" id="clientSecret" aria-describedby="clientSecretHelp" value="" required>
            <div id="clientSecretHelp" class="form-text"> Secret key that is assigned to your app by Clover. Together, the client ID and client secret authenticate the identity of your app with the clover server.
            </div>
          </div>

          <!-- Add more form fields here if needed -->
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
