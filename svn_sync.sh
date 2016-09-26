#!/bin/sh

mkdir tmp/szamlahegy-woocommerce-git
svn co https://plugins.svn.wordpress.org/szamlahegy-woocommerce/ tmp/szamlahegy-woocommerce-svn
git archive master | tar -x -C tmp/szamlahegy-woocommerce-git/
cd api
git archive master | tar -x -C ../tmp/szamlahegy-woocommerce-git/api
