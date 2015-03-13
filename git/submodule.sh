basePath='/tmp/';

git config --global user.email='hdwcl@163.com'
git config --global user.name='acanstudio'

mkdir /tmp/git
mkdir /tmp/git/{repos,workspace}
cd /tmp/git/repos/

git --git-dir=lib1.git init --bare
git --git-dir=lib2.git init --bare
git --git-dir=project1.git init --bare
git --git-dir=project2.git init --bare

cd /tmp/git workspace
git clone ../repos/project1.git
cd project1
echo 'project1' > project-infos.txt
git add project-infos.txt
git commit -m 'init project1'
git push origin master

cd ../
git clone ../repos/project2.git
cd project2
echo 'project2' > project-infos.txt
git add project-infos.txt
git commit -m 'init project2'
git push origin master

cd ..
git clone ../repos/lib1.git
cd lib1
echo "I'm lib1" > lib1-features
git add lib1-features
git commit -m 'init lib1'
git push origin master

cd ..
git clone ../repos/lib2.git
cd lib2
echo "I'm lib2" > lib2-features
git add lib2-features
git commit -m 'init lib2'
git push origin master

cd ../project1
git submodule add /tmp/git/repos/lib1.git libs/lib1
git submodule add /tmp/git/repos/lib2.git libs/lib2
#ls; ls libs; git status
git commit -a -m 'add submodules[lib1,lib2] to project1'
git push origin master

cd ..
git clone ../repos/project1.git project1_new
cd project1_new
git submodule
git submodule init
git submodule update

cd libs/lib1
#git status; cat ../../.git/modules/libs/lib1/HEAD; cat ../../.git/modules/libs/lib1/refs/heads/master;
git checkout master
echo 'add by developer new' >> lib1-features
git commit -a -m 'update lib1-features'
#git status;
cd ../../
#git status; git diff;

cd libs/lib1
git push origin master
cd ../../
git add -u 
git commit -m 'update libs/lib1 to lastest commit id'
git push origin master

cd ../project1
git pull
#git status; git diff
git submodule update
#git status; cat .git/config
git submodule init
git submodule update
