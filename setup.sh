function do_setup(){

set -e

local RED=`tput setaf 1`
local GREEN=`tput setaf 2`
local BLUE=`tput setaf 6`
local YELLOW=`tput setaf 3`
local PURPLE=`tput setaf 5`
local NC=`tput sgr0` # No Color
local TAG="${BLUE}F / R / A / M / E  ${NC}:::: "
local NL=`tput il 1`
local LINE="------------------------------------------------------------------------------"

local SCRIPT=`realpath $0`
local SCRIPTPATH=`dirname $SCRIPT`

echo $SCRIPTPATH;

echo ${LINE};
echo "";
echo "${TAG}Boilerplate setup"
echo "";
echo ${LINE}

echo "";
echo "";
echo "${GREEN}Please enter a project name, this is usually the directory name:${NC} [enter]";
echo "";
read name;

if [ $name == '' ]; then
    echo "${RED}Error: You must provide a project name, see the README.md file for more info";
    exit 1;
fi

echo "";
echo "";
echo ${LINE};
echo "";
echo "${TAG} ${GREEN}Find / replace"${NC};
echo "";
echo ${LINE}

echo "";
echo -n ":: ${YELLOW}Project name setup${NC} - find/replace in .php files";
find ${SCRIPTPATH}/ -name '*.php' -exec sed -i "s/%%PROJECTNAME%%/${name}/g" {} \;
echo "";
echo -n ":: ${YELLOW}Project name setup${NC} - find/replace in .json files";
find ${SCRIPTPATH}/ -name '*.json' -exec sed -i "s/%%PROJECTNAME%%/${name}/g" {} \;
echo "";
echo -n ":: ${YELLOW}Project name setup${NC} - find/replace in env file";
find ${SCRIPTPATH}/ -name 'env' -exec sed -i "s/%%PROJECTNAME%%/${name}/g" {} \;
echo "";
echo -n ":: ${YELLOW}Project name setup${NC} - find/replace in .yml files";
find ${SCRIPTPATH}/ -name '*.yml' -exec sed -i "s/%%PROJECTNAME%%/${name}/g" {} \;
find ${SCRIPTPATH}/ -name '*.yaml' -exec sed -i "s/%%PROJECTNAME%%/${name}/g" {} \;
echo "";
echo "";

echo ${LINE};
echo "";
echo "${TAG} Config Setup"
echo "";
echo ${LINE}

echo -n "  :: Setting up .env file"
cp env .env
echo "";
echo ""


echo ${LINE};
echo "";
echo "${TAG} Composer Setup"
echo "";
echo ${LINE}
echo "";
echo ""

composer install --prefer-source --ignore-platform-reqs

echo "";
echo ""

echo ${LINE};
echo "";
echo "${TAG} Yarn / Front End Setup"
echo "";
echo ${LINE}
echo "";
echo ""

yarn && yarn build


echo "";
echo "🔥 🔥 ${GREEN}Setup Complete 🔥 🔥"
echo "";
echo "";
echo "${NC}Some tasks still required for setup - see README.md for more info"
echo "";
echo "- Read hacker news while this bash script makes you look busy 💁"
echo "- replace salts in .env with real ones - see http://wordplate.github.io/salt/"
echo "- Setup homestead.yml entry for this site"
echo "- Edit wp-cli.yml if your homestead vagrant mount path is different"
echo "- Create Homestead ssh config (see README.md)"
echo "- Create database named \"${name}\" if you haven't already"
echo "- Actually develop the site 📈"

}

do_setup