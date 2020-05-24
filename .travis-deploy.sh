#!/bin/bash
set -e

if [ "${TRAVIS_EVENT_TYPE}" == "cron" ]; then
  exit 0
fi

DEPLOY_REV=$(git rev-parse --short HEAD)
HHVM_VERSION=$(awk '/APIProduct::HACK/{print $NF}' src/codegen/PRODUCT_TAGS.php | cut -f2 -d- | cut -f1-2 -d.)
IMAGE_TAG="HHVM-${HHVM_VERSION}-$(date +%Y-%m-%d)-${DEPLOY_REV}"
IMAGE_NAME=hhvmcn/user-documentation:$IMAGE_TAG

echo "** Building repo..."
if [ "$(uname -s)" == "Darwin" ]; then
  # MacOS Darwin gives us somewhere Docker doesn't like by default
  REPO_OUT=/tmp/repo-out
else
  REPO_OUT="$(mktemp -d)"
fi
docker run --rm \
  -v "$REPO_OUT:/var/out"  \
  -w /var/www \
  hhvmcn/user-documentation:scratch \
  .deploy/build-repo.sh

echo "** Building Docker image..."
cp hhvm.prod.ini "$REPO_OUT/"
cp .deploy/prod.Dockerfile "$REPO_OUT/Dockerfile"
(
  cd "$REPO_OUT"
  docker build \
    -t "$IMAGE_NAME" \
    .
)

echo "** Logging in to dockerhub..."
echo "${DOCKERHUB_PASSWORD}" | docker login -u "${DOCKERHUB_USER}" \
  --password-stdin
echo "** Pushing image to DockerHub..."
docker tag $IMAGE_NAME hhvmcn/user-documentation:latest
docker push "$IMAGE_NAME"
docker push "hhvmcn/user-documentation:latest"
