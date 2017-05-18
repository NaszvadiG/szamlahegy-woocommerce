#!/bin/sh

PLUGIN_VERSION="1.2.4"
API_VERSION="3.2.0"

rm -rf tmp/szamlahegy-woocommerce-git tmp/szamlahegy-woocommerce-svn
mkdir tmp/szamlahegy-woocommerce-git
svn co https://plugins.svn.wordpress.org/szamlahegy-woocommerce/ tmp/szamlahegy-woocommerce-svn
git archive v$PLUGIN_VERSION | tar -x -C tmp/szamlahegy-woocommerce-git/
cd api
git archive v$API_VERSION | tar -x -C ../tmp/szamlahegy-woocommerce-git/api
cd ..
rm -rf tmp/szamlahegy-woocommerce-git/.git* tmp/szamlahegy-woocommerce-git/api/.git* tmp/szamlahegy-woocommerce-git/svn_sync*
rm -rf tmp/szamlahegy-woocommerce-svn/trunk/*
cp -r tmp/szamlahegy-woocommerce-git/* tmp/szamlahegy-woocommerce-svn/trunk/
cd tmp/szamlahegy-woocommerce-svn
svn cp trunk tags/$PLUGIN_VERSION
svn ci -m "new version: $PLUGIN_VERSION"
