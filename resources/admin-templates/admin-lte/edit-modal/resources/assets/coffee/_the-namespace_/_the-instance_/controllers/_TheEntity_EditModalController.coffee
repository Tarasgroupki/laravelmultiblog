app.controller '_TheEntity_EditModalController', ($scope, $modalInstance, _theEntity_, readonly, _TheEntity_)->
  $scope._theEntity_ = _theEntity_
  $scope.readonly = readonly

  $scope.ok = ->
    _TheEntity_.update(_theEntity_).$promise.then((result)->
      console.log(result)
    )

    $modalInstance.close($scope._theEntity_)

  $scope.cancel = ->
    $modalInstance.close()
